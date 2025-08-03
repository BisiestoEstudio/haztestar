<?php

namespace BIS_Core;

class Service_Controller {

	static function init(){
		// Hook into WooCommerce order creation
		error_log('HazTestar: Service Controller initialized');
		add_action('woocommerce_new_order', array(__CLASS__, 'log_order_data'), 10, 1);
	}

	/**
	 * Log all order data when a new order is created
	 * 
	 * @param int $order_id The order ID
	 */
	static function log_order_data($order_id) {
		error_log('HazTestar: Logging order data for order ID: ' . $order_id);
		// Get the order object
		$order = wc_get_order($order_id);
		
		if (!$order) {
			error_log('HazTestar: Failed to get order object for order ID: ' . $order_id);
			return;
		}

		// Format date as dd/mm/YYYY
		$date_created = $order->get_date_created();
		$fecha = $date_created->date('d/m/Y');
		$preferida = $order->get_meta('_billing_preferencia') ?: '';
		$dni = $order->get_meta('_billing_nif') ?: '';

		// Get all order data
		$order_data = $order->get_data();

		$data = array(
			'STAR' => $order_id,
			'FECHA' => $fecha,
			'NOMBRE' => $order_data['billing']['first_name'],
			'APELLIDOS' => $order_data['billing']['last_name'],
			'EMAIL' => $order_data['billing']['email'],
			'TELEFONO' => $order_data['billing']['phone'],
			'DOMICILIO' => $order_data['billing']['address_1'],
			'CIUDAD' => $order_data['billing']['city'],
			'CODIGO_POSTAL' => $order_data['billing']['postcode'],
			'PREFERIDA-1' => $preferida,
			'DOCUMENTO' => $dni,
		);


		$api_hercesa = new Api_Hercesa($data);
		$response = $api_hercesa->send_contact($data);
		error_log('HazTestar: Response: ' . print_r($response, true));
	}
}

Service_Controller::init();
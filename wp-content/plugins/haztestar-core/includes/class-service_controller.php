<?php

namespace BIS_Core;

class Service_Controller {

	static function init(){
		// Hook into WooCommerce order creation
		add_action('woocommerce_new_order', array(__CLASS__, 'log_order_data'), 10, 1);
	}

	/**
	 * Log all order data when a new order is created
	 * 
	 * @param int $order_id The order ID
	 */
	static function log_order_data($order_id) {
		// Get the order object
		$order = wc_get_order($order_id);
		
		if (!$order) {
			return;
		}

		// Format date as dd/mm/YYYY
		$date_created = $order->get_date_created();
		$fecha = $date_created->date('d/m/Y');
		$preferida_data = $order->get_meta('_billing_promocion') ?: '';
		error_log('HazTestar: Preferencia data: ' . $preferida_data);
		$preferida_data = explode('__', $preferida_data);
		error_log('HazTestar: Preferencia data: ' . print_r($preferida_data, true));
		$preferida = $preferida_data[0] ?? '';
		$preferida = strtoupper($preferida);
		$codigo_oficina = $preferida_data[1] ?? '';
		$codigo_oficina = strtoupper($codigo_oficina);

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
			'OFICINA' => $codigo_oficina,
		);


		$api_hercesa = new Api_Hercesa($data);
		$response = $api_hercesa->send_contact($data);
		error_log('HazTestar: Response: ' . print_r($response, true));
	}
}

Service_Controller::init();
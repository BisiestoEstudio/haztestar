<?php

namespace BIS_Core;

class Service_Controller {

	static function init(){
		// Hook into WooCommerce order creation
		add_action('woocommerce_order_status_completed', array(__CLASS__, 'send_to_prinex'), 10, 1);
		
	}

	/**
	 * Log all order data when a new order is created
	 * 
	 * @param int $order_id The order ID
	 */
	static function send_to_prinex($order_id) {
		// Get the order object
		$order = wc_get_order($order_id);
		//order number
		$order_number = $order->get_order_number();
		
		if (!$order) {
			return;
		}

		// Format date as dd/mm/YYYY
		$date_created = $order->get_date_created();
		$fecha = $date_created->date('d/m/Y');
		$slug = $order->get_meta('_billing_promocion') ?: '';
		$piso = $order->get_meta('_billing_piso') ?: '';
		$puerta = $order->get_meta('_billing_puerta') ?: '';
		$escalera = $order->get_meta('_billing_escalera') ?: '';
		$numero = $order->get_meta('_billing_numero') ?: '';
		$numero_dormitorios = $order->get_meta('_billing_dormitorios') ?: '';
		$tipo_via = $order->get_meta('_billing_via') ?: '';

		$dni = $order->get_meta('_billing_nif') ?: '';

		// Get all order data
		$order_data = $order->get_data();

		$data = array(
			'STAR' => $order_number,
			'FECHA' => $fecha,
			'NOMBRE' => $order_data['billing']['first_name'],
			'APELLIDOS' => $order_data['billing']['last_name'],
			'EMAIL' => $order_data['billing']['email'],
			'MOVIL' => $order_data['billing']['phone'],
			'DOMICILIO' => $order_data['billing']['address_1'],
			'POBLACION' => $order_data['billing']['city'],
			'PROVINCIA' => $order_data['billing']['state'],
			'PREFERIDA_SLUG' => $slug,
			'DORMITORIOS' => $numero_dormitorios,
			'DOCUMENTO' => $dni,
			'CODIGO_POSTAL' => $order_data['billing']['postcode'],
			'PISO' => $piso,
			'PUERTA' => $puerta,
			'ESCALERA' => $escalera,
			'NUMERO_VIA' => $numero,
			'TIPO_VIA' => $tipo_via,
		);


		$api_hercesa = new Api_Hercesa($data);
		$response = $api_hercesa->send_contact($data);

		error_log('HazTestar: Response: ' . print_r($response, true));
		error_log('HazTestar: Data: ' . print_r($data, true));
	}
}

Service_Controller::init();
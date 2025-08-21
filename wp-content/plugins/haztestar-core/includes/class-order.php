<?php

namespace BIS_Core;

class Order {

	static function init(){
		// Add bulk actions to orders list
		add_filter('bulk_actions-edit-shop_order', array(__CLASS__, 'add_bulk_actions'));
		add_filter('handle_bulk_actions-edit-shop_order', array(__CLASS__, 'handle_bulk_actions'), 10, 3);
	}

	/**
	 * Add bulk actions to the orders list
	 * 
	 * @param array $actions Array of bulk actions
	 * @return array Modified array of bulk actions
	 */
	static function add_bulk_actions($actions) {
		$actions['prinex_action'] = __('Enviar a Prinex', 'haztestar-core');
		return $actions;
	}

	/**
	 * Handle bulk actions execution
	 * 
	 * @param string $redirect_to URL to redirect to after processing
	 * @param string $doaction The action being taken
	 * @param array $post_ids Array of post IDs to process
	 * @return string Modified redirect URL
	 */
	static function handle_bulk_actions($redirect_to, $doaction, $post_ids) {
		if ($doaction !== 'prinex_action') {
			return $redirect_to;
		}

		foreach ($post_ids as $post_id) {
			error_log('Action executed for order: ' . $post_id);
            Service_Controller::send_to_prinex($post_id);

		}

		// Redirect to prevent form resubmission
		$redirect_to = add_query_arg('bulk_action', 'prinex_action', $redirect_to);
		return $redirect_to;
	}
}

Order::init();
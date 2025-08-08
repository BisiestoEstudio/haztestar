<?php

namespace BIS_Core;



class Api_Hercesa {

	private $data;
	private $api_url = API_URL;
	private $user_name = USER_NAME;
	private $api_key = API_KEY;

	static function init() {
	}

	public function __construct($data) {
		$this->data = $data;
	}

	public function send_contact($data){
		//Data to json
		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		$url = $this->api_url;
		$response = wp_remote_post($url, array(
			'method' => 'POST',
			'timeout' => 30,
			'headers' => array(
				'Authorization' => 'Basic ' . base64_encode($this->user_name . ':' . $this->api_key)
			),
			'body' => $data
		));

		if (is_wp_error($response)) {
			error_log('HazTestar: Error sending contact: ' . $response->get_error_message());
			return false;
		}

		$response_body = json_decode($response['body'], true);
		return $response;
	}


}

Api_Hercesa::init();
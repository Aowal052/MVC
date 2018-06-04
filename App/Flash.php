<?php

namespace App;

class Flash{

	const SUCCESS = 'success';
	const INFO  = 'info';
	const WARNING = 'warning';

	public static function  add_msg($msg, $type = 'success'){
		if (! isset($_SESSION['flash_notification'])) {
			$_SESSION['flash_notification'] = [];
		}

		$_SESSION['flash_notification'][] = [
			'body' => $msg,
			'type' => $type
		];
	}

	public static function get_msg(){
		if (isset($_SESSION['flash_notification'])) {
			$message = $_SESSION['flash_notification'];
			unset($_SESSION['flash_notification']);
			return $message;
		}
	}
}

?>
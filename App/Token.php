<?php

namespace App;
class Token {

	protected $token;
	
	function __construct($token_value = null){
		if ($token_value) {
			$this->token = $token_value;
		}else{
			$this->token = bin2hex(mt_rand(16, 32));
		}
		
	}

	public function get_value(){
		return $this->token;
	}

	public function get_hash(){
		return hash_hmac('sha256', $this->token, \App\Config::SECRET_KYE);
	}
}

?>
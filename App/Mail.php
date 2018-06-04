<?php

namespace App;
use Mailgun\Mailgun;
/**
* 
*/
class Mail {
	
	public static function  send($to, $subject, $text, $html){
		# First, instantiate the SDK with your API credentials
	$mg = new Mailgun(config::MAILGUN_API_KEY);
	$domain = config::MAILGUN_DOMAIN;

	# Now, compose and send your message.
	# $mg->messages()->send($domain, $params);
	$mg->sendMessage($domain,array('from'     => 'bob@example.com',
								   'to'       => $to,
								   'subject'  => $subject,
								   'text'     => $text,
								   'html'	  => $html));
	}
}
?>
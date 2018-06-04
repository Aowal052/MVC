<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
class Items extends Authenticated
{
	protected function before(){
		$this->require_login();
	}

    public function indexAction(){
        //$this->require_login();
        View::renderTemplate('Items/index.html');

        
    }
}

<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Auth;

class Users extends \Core\Controller{

    protected function before(){
        $this->require_login();
    }
    public function indexAction(){
        //echo 'User admin index';
        View::renderTemplate('Admin/Admin.html');
     //    if (isset($_SESSION['user_id'])) {
    	// 	echo $_SESSION['user_id'];
    	// }
    }
}

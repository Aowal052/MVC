<?php

namespace App\Controllers;
use \Core\View;
use App\Models\User;

class Signup extends \Core\Controller{
	public function signupAction(){
		View::renderTemplate('Signup/signup.html');
	}

	public function createAction(){
		//var_dump($_POST);
		$user = new User($_POST);

        if ($user->save()) {
        	//$this->redirect();
        	//$this->redirect('/Signup/success.html');
           -View::renderTemplate('Signup/success.html');

       } else {
       		View::renderTemplate('Signup/signup.html', [
       			'user' => $user
       			]);

           //var_dump($user->errors);

       }
	}

	public function successAction(){
		View::renderTemplate('Signup/success.html');
	}
}
?>
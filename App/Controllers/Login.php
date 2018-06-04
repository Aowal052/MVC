<?php
namespace App\Controllers;
use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends \Core\Controller {
	
	public function loginAction(){
		View::renderTemplate('Login/login.html');
	}

	public function createAction(){
		$user = User::authenticate($_POST['email'], $_POST['password']);
		$remember_me = isset($_POST['remember_me']);
		// $user = User::findByMail($_POST['email']);
		//var_dump($_POST);
		if ($user) {
			Auth::login($user, $remember_me);
			Flash::add_msg('Login Successfuly..');
			$this->redirect('/Admin/Users/index');
		}else{
			Flash::add_msg('Login unsuccessful, please try again', Flash::WARNING);
			View::renderTemplate('Login/login.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
                ]);
		}
	}

	public function destroyAction(){
		Auth::logout();
		$this->redirect('/login/show-logout-message');
	}
	public function showLogoutMessageAction(){
		Flash::add_msg('Logout Successfuly..');
		$this->redirect('/');
	}
}
?>
<?php

namespace App;
use App\Models\User;
use App\Models\RememberLogin;

class Auth {

	public static function login($user, $remember_me){
		session_regenerate_id(true);
		$_SESSION['user_id'] = $user->user_id;
		if ($remember_me) {
			//$user->remember_login();
            if ($user->remember_login()) {

                setcookie('remember_me', $user->remember_token, $user->expire_timestamp, '/');

            }
        }
	}

	public static function logout(){
		$_SESSION = [];

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(
		    	session_name(),
		    	'', 
		    	time() - 42000,
		        $params["path"], 
		        $params["domain"],
		        $params["secure"], 
		        $params["httponly"]
		    );
		}

		// Finally, destroy the session. 
		session_destroy();
		static::forget_login();
	}

	// public static function is_loged_in(){
	// 	return isset($_SESSION['user_id']);
	// }

	public static function remember_requested_page(){
		$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
	}

	public static function getReturnToPage(){
        //return $_SESSION['return_to'] ?? '/Admin/Users/index';
        //$this->redirect('/Admin/Users/index');
    }

    public static function get_user(){
    	if (isset($_SESSION['user_id'])) {
    		return User::findById($_SESSION['user_id']);
    		//echo $SESSION['user_name'];

    	}else{
    		return static::login_from_remember_cookie();
    	}
    }

    protected static function login_from_remember_cookie(){
    	//$cookie = $_COOKIE['remember_me'] ?? false;
    	$cookie = $_COOKIE['remember_me'] ? $_COOKIE['remember_me'] : false;

    	if ($cookie) {
    		$remember_login = RememberLogin::findByToken($cookie);
    		if ($remember_login && !$remember_login->has_expired()) {
    			$user = $remember_login->get_user();
    			static::login($user, false);
    			return $user;
    		}
    	}
    }

    protected static function forget_login(){
    	$cookie = $_COOKIE['remember_me'] ? $_COOKIE['remember_me']: false;

    	if ($cookie) {
    		$remember_login = RememberLogin::findByToken($cookie);
    		if ($remember_login){
    			$remember_login->delete();
    		}
    	}
    }
}
?>
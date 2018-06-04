<?php

namespace Core;
use \App\Auth;
use \App\Flash;
/**
 * Base controller
 *
 * PHP version 5.4
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before(){
        //$this->require_login();
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after(){
    }

    public function redirect($url){
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url , true, 303);
        exit;
    }

    public function require_login(){
        if (! Auth::get_user()) {
            Flash::add_msg('Please Login To Access That Page', Flash::INFO);
            Auth::remember_requested_page();
            
            //View::renderTemplate('Login/login.html');
            $this->redirect('/login?message=please login first.');
        }
    }
}
<?php

require '../vendor/autoload.php';

ini_set('session.cookie_lifetime', '864000');
Twig_Autoloader::register();


error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('signup', ['controller' => 'signup', 'action' => 'signup']);
$router->add('login', ['controller' => 'login', 'action' => 'login']);
$router->add('logout', ['controller' => 'login', 'action' => 'destroy']);
$router->add('admin', ['controller' => 'Admin', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
    
$router->dispatch($_SERVER['QUERY_STRING']);
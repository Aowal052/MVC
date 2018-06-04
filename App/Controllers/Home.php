<?php

namespace App\Controllers;
use \App\Auth;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 5.4
 */
class Home extends \Core\Controller
{

    /**
     * Before filter
     *
     * @return void
     */
    protected function before()
    {
        //echo "(before) ";
        //return false;
    }

    /**
     * After filter
     *
     * @return void
     */
    protected function after()
    {
        //echo " (after)";
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        /*
        View::render('Home/index.php', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
        */
        \App\Mail::send('demo@daveh.in', 'Test', 'This Is A Test', '<h1>this is a test.</h1>'); 
        View::renderTemplate('Home/index.html', [
            'user'=> Auth::get_user()
        ]);
    }
}

<?php

namespace Core;


class View
{

    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file =dirname(__DIR__) . "../App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
            //$twig->addGlobal('session', $_SESSION);
            //$twig->addGlobal('is_loged_in',\App\Auth::is_loged_in());
            $twig->addGlobal('current_user',\App\Auth::get_user());
            $twig->addGlobal('flash_message',\App\Flash::get_msg());
        }

        echo $twig->render($template, $args);
    }
}

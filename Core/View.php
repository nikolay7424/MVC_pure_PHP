<?php


namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";

        if (is_readable($file))
        {
            require $file;
        }else{
            echo "$file not found";
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null)
        {
            $loader = new FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new Environment($loader);
        }
        echo $twig->render($template, $args);
    }
}
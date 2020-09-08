<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//require '../App/Controllers/Posts.php';
require_once '../vendor/autoload.php';
//require '../Core/Router.php';

spl_autoload_register(function ($class){
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if(is_readable($file))
    {
        require $file;
    }
});

$router = new Core\Router;

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$url = $_SERVER['QUERY_STRING'];

$router->dispatch($url);
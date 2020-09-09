<?php

require_once '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');



$router = new Core\Router;

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$url = $_SERVER['QUERY_STRING'];

$router->dispatch($url);
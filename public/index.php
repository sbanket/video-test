<?php

use App\Router\Router;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('App\Error\Error::errorHandler');
set_exception_handler('App\Error\Error::exceptionHandler');

/** @var array $routes */
$routes = include(__DIR__ . '/../app/Config/routes.php');

$router = new Router($routes);
$router->run();

?>
<?php
session_start();
use Core\Router;

spl_autoload_register(function ($className){
	include __DIR__ . '/application/' . str_replace("\\", "/", $className) . '.php';
});

error_reporting(E_ALL);
ini_set('display_errors', 1);

// массив роутеров
$routes = require $_SERVER['DOCUMENT_ROOT'] . '/application/config/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($routes, $uri);
$router->controller();

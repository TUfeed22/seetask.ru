<?php
session_start();

use application\Configuration\Application;
use application\Core\Router;

spl_autoload_register(function ($className){
	include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace("\\", "/", $className) . '.php';
});

error_reporting(E_ALL);
ini_set('display_errors', 1);

// массив роутеров
$routes = require Application::basePath() . '/application/Configuration/routes.php';
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($routes, $uri);
$router->controller();

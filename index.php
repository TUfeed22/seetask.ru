<?php

use app\Core\Controller\ControllerFactory;
use app\Core\Router;

spl_autoload_register(function ($className){
    include '/var/www/seetask.ru/' . str_replace('\\', '/', $className) . '.php';
});

$url =  $_SERVER['REQUEST_URI'];

$router = new Router($url);
$controller = ControllerFactory::create($router);
echo $controller->actionUser();

echo "<pre>";
print_r($router);
echo "</pre>";
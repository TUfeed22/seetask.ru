<?php

use app\Database\Connection;
use app\Settings\Settings;

spl_autoload_register(function ($className){
    include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace("\\", "/", $className) . '.php';
});


var_dump(Settings::getConfig('app.php'));

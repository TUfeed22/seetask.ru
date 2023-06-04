<?php

use app\Database\Connection;
use app\Settings\Settings;

spl_autoload_register(function ($className){
    include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace("\\", "/", $className) . '.php';
});


var_dump(gettype(Settings::getConfig('app.php')));
print_r(Settings::getConfig('app.php')->configPath);
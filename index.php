<?php

use app\Settings\Settings;

spl_autoload_register(function ($className){
    include $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace("\\", "/", $className) . '.php';
});

$settings = Settings::getConfig('database.php');

print_r($settings->db_host);
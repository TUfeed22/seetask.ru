<?php

unset($argv[0]);

spl_autoload_register(function ($className){
    include '/var/www/seetask.ru/' . str_replace('\\', '/', $className) . '.php';
});

$className =  'app\\Commands\\' . ucfirst(array_shift($argv) . 'Command');
$method = 'action' . ucfirst(array_shift($argv));

$params = [];
foreach ($argv as $argument) {
    preg_match("/^--(\w+)=(\w+)$/", $argument, $matches);

    if (!empty($matches)) {
        $paramName = $matches[1];
        $paramValue = $matches[2];

        $params[$paramName] = $paramValue;
    }

}

call_user_func_array(array(new $className(), $method), $params);

<?php

namespace app\Core\Controller;

use app\Controllers\Error404Controller;
use app\Core\Router;
use app\Settings\Settings;

abstract class ControllerFactory
{
    /**
     * Получаем экземпляр контроллера
     * @param Router $router
     * @return Error404Controller|mixed
     */
    public static function create(Router $router): mixed
    {
        $class = 'app\\Controllers\\' . ucfirst($router->controller) . 'Controller';
        return self::getClassOr404($class);
    }

    private static function checkClass($class): bool
    {
        $classPath = Settings::getConfig('app.php')->basePath . '/' . str_replace('\\', '/', $class) . '.php';

        return file_exists($classPath);
    }

    /**
     * Проверка существования контроллера, если его нет то возвращаем 404
     * @param $class
     * @return Error404Controller|mixed
     */
    private static function getClassOr404($class): mixed
    {
        if (self::checkClass($class)) {
            return new $class();
        }
        $class = 'app\\Controllers\\Error404Controller';
        return new $class();
    }
}
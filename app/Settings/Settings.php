<?php
namespace app\Settings;

class Settings
{
    /**
     * Получить конфигурацию
     *
     * @param string $file Файл конфигурации
     * @return mixed
     */
    public static function getConfig(string $file): mixed
    {
        $path = 'params/' . $file;
        return require $path;
    }
}
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
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/config/' . $file;
        return require $path;
    }
}
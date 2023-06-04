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
        $path = '/var/www/seetask.ru/app/config/' . $file;

        if (!file_exists($path)) {
            return null;
        }
        return require $path;
    }
}
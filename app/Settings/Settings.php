<?php
namespace app\Settings;

class Settings
{
    const PATH_FILE_CONFIGURATION = '/var/www/seetask.ru/app/config/';

    /**
     * Получить конфигурацию
     *
     * @param string $file Файл конфигурации
     * @return mixed
     */
    public static function getConfig(string $file): mixed
    {
        $path = self::PATH_FILE_CONFIGURATION . $file;

        if (self::fileConfigurationExists($path)) {
            $config = require $path;
            if (self::fileConfigurationEmpty($config) || gettype($config) != 'object') {
                return null;
            }
            return $config;
        } else {
            return null;
        }
    }

    /**
     * Существует ли файл конфигурации
     *
     * @param $path
     * @return bool
     */
    public static function fileConfigurationExists($path): bool
    {
        return file_exists($path);
    }

    /**
     * Не пустой ли файл конфигурации
     *
     * @param $path
     * @return bool
     */
    public static function fileConfigurationEmpty($path): bool
    {
        return empty($path);
    }
}
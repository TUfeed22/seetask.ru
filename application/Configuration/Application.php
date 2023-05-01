<?php
namespace application\Configuration;

class Application
{
	/**
	 * Базовый путь по умолчанию - /var/www/seetask.ru
	 * @return mixed
	 */
	public static function basePath(): mixed
	{
		return $_SERVER['DOCUMENT_ROOT'];
	}
}

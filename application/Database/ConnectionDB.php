<?php
namespace Database;
use PDO;
use PDOException;
use Exception;

/**
 * Класс подключения к базе данных. Реализовано через паттерн singleton
 */
final class ConnectionDB
{

	private const DB_USER = 'root';
	private const DB_USER_PASSWORD = 'root';
	private const DB_NAME = 'dashboard_db';
	private const DB_HOST = 'dash_db';

	/**
	 * @var ConnectionDB|null
	 */
	private static ?ConnectionDB $instance = null;

	private function __construct()
	{
	}

	private function __clone()
	{

	}

	/**
	 * Реализация паттерна singleton
	 * @return static
	 */
	public static function getInstance(): self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Подключение к базе данных
	 * @return PDO
	 * @throws Exception
	 */
	public function connection(): PDO
	{
		try {
			$dsn = sprintf("pgsql:host='%s';port=5432;dbname='%s';user='%s';password='%s'",
				self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_USER_PASSWORD);

			return new PDO($dsn, options:[PDO::ATTR_PERSISTENT=>true]);
		} catch (PDOException $e) {
			throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage() . PHP_EOL);
		}
	}
}
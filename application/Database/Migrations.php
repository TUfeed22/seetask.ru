<?php
namespace Database;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Migrations
{
  const TABLE_MIGRATION_VERSIONS = 'migration_versions';

	/**
	 * @throws Exception
	 */
	public function createTableMigrationVersions(): PDOStatement|false
  {
	  $connection = ConnectionDB::getInstance()->connection();
    // проверяем существование таблицы
    $checkTableMigrationVersions = self::checkTable(self::TABLE_MIGRATION_VERSIONS);
    $tableMigrationVersionsExists = $checkTableMigrationVersions->fetch(PDO::FETCH_ASSOC);
    // создаем таблицу, если ее не существует
    if (!$tableMigrationVersionsExists['exists']) {
      echo 'Создаем таблицу "' . self::TABLE_MIGRATION_VERSIONS .'"' . PHP_EOL;
      $query = "CREATE TABLE " . self::TABLE_MIGRATION_VERSIONS . " (version varchar(255) NOT NULL)";

      try{
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt;
      } catch (PDOException $e) {
        echo 'Ошибка при создании таблицы "' . self::TABLE_MIGRATION_VERSIONS .'": ' . $e->getMessage() . PHP_EOL;
      }

    }
    return $checkTableMigrationVersions;
  }

	/**
	 * Получаем миграции
	 * @throws Exception
	 */
  public function getMigrationFiles($tableMigrationVersions, $migrationFiles): array
  {
	  $connection = ConnectionDB::getInstance()->connection();
    // формируем массив из имен файлов
    $nameMigrationFiles = [];
    foreach ($migrationFiles as $migrationFile) {
      $nameMigrationFiles[] = basename($migrationFile);
    }

    // если таблица пустая, возвращаем все файлы
    if (!$tableMigrationVersions) {
      return $nameMigrationFiles;
    }

    // запрашиваем примененные миграции
    $query = "SELECT version FROM " . self::TABLE_MIGRATION_VERSIONS;
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $tableMigrationVersionsRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // формируем массив из имен
    $migrationVersions = [];
    foreach ($tableMigrationVersionsRows as $row) {
      $migrationVersions[] = $row['version'];
    }

    // возвращаем разницу
    return array_diff($nameMigrationFiles, $migrationVersions);
  }

	/**
	 * Выполнение запроса
	 * @throws Exception
	 */
  public function executeQuery($query): bool
  {
	  $connection = ConnectionDB::getInstance()->connection();
    try{
      $stmt = $connection->prepare($query);
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo "  => Во время выполнения запроса произошла ошибка: " . $e->getMessage() . PHP_EOL;
      return false;
    }
  }

	/**
	 * Существует ли таблица.
	 * Если таблица не существует то, возвращает пустое значение (в прямом смысле этого слова).
	 * Иначе возвращает 1.
	 * @param string $tableName Имя таблицы
	 * @throws Exception
	 */
	public static function checkTable(string $tableName): bool|PDOStatement
	{
		$connection = ConnectionDB::getInstance()->connection();
		$query = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE TABLE_NAME = '" . $tableName . "')";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt;
	}
}
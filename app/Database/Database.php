<?php

namespace app\Database;

use app\Database\Builder\PgSqlQueryBuilder;
use Exception;
use PDO;

class Database
{
    /**
     * Существует ли таблица
     * @param $tableName
     * @return bool
     */
    public static function checkTable($tableName): bool
    {
        $pdo = Connection::db()->connection;
        $query = "SELECT EXISTS(SELECT * FROM information_schema.tables where table_name = '$tableName')";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['exists'] == 1;
    }

    /**
     * @param string $tableName Наименование таблицы
     * @param array $columns Ассоциативный массив, например ['tableName' => 'varchar(255) NOT NULL']
     * @return void
     */
    public static function createTable(string $tableName, array $columns): void
    {
        $pdo = Connection::db()->connection;
        $query = "CREATE TABLE $tableName (";

        foreach ($columns as $column => $param) {
            $query .= "$column $param,";
        }

        $query = substr_replace($query, ');', -1, 1);
        $pdo->prepare($query)->execute();
    }

    /**
     * Запросить все записи
     * @param string $tableName
     * @param array $columns
     * @return bool|array
     * @throws Exception
     */
    public static function fetchAll(string $tableName, array $columns = ['*']): bool|array
    {
        $pdo = Connection::db()->connection;
        $query = PgSqlQueryBuilder::createSql()
            ->select($columns)
            ->from($tableName)
            ->build();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchall(PDO::FETCH_COLUMN);
    }

    /**
     * Удаление таблицы
     * @param $table
     * @return void
     * @throws Exception
     */
    public static function deleteTable($table): void
    {
        $pdo = Connection::db()->connection;
        $pdo->prepare("DROP TABLE $table")->execute();
    }
}
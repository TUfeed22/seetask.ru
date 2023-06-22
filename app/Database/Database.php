<?php

namespace app\Database;

use app\Database\Builder\QueryBuilder;
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
        $query = "SELECT EXISTS (SELECT FROM information_schema.columns WHERE table_name = '$tableName')";
        $stmt = $pdo->prepare($query);
        return $stmt->execute();
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
            $query .= "$column $param";
            if (array_key_last($columns) != $column) {
                $query .= ',';
            }
        }
        $query = ");";

        $pdo->prepare($query)->execute();
    }

    /**
     * @param string $tableName
     * @param string $columns
     * @return bool|array
     */
    public static function fetchAll(string $tableName, string $columns = '*'): bool|array
    {
        $pdo = Connection::db()->connection;
        $queryBuilder = new QueryBuilder();
        $stmt = $pdo->prepare($queryBuilder
            ->select($columns)
            ->from($tableName)
            ->builder()
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
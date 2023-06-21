<?php

namespace app\Database;

class Database
{
    public static function getTable($tableName)
    {
        $connection = Connection::db()->connection;
        $query = "SELECT EXISTS (SELECT FROM information_schema.columns WHERE table_name = '$tableName')";
        $stmt = $connection->prepare($query);

    }
}
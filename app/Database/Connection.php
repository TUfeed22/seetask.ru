<?php
namespace app\Database;
use app\Settings\Settings;
use PDO;

final class Connection
{
    private static ?Connection $_connection;
    public PDO $connection;

    private function __construct()
    {
        $dbConfig = Settings::getConfig('database.php');
        $dsn = "pgsql:host=$dbConfig->db_host;port=$dbConfig->db_port;
                dbname=$dbConfig->db_name;user=$dbConfig->db_user;password=$dbConfig->db_password";
        $this->connection = new PDO($dsn);
    }
    private function __clone(){}

    public static function db(): ?Connection
    {
        self::$_connection ??= new self();
        return self::$_connection;
    }
}
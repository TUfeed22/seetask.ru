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
        $connectConfig = Settings::getConfig('database.php');
        $dsn = "pgsql:host=$connectConfig->db_host;port=$connectConfig->db_port;
                dbname=$connectConfig->db_name;user=$connectConfig->db_user;password=$connectConfig->db_password";
        $this->connection = new PDO($dsn);
    }
    private function __clone(){}

    public static function db(): ?Connection
    {
        self::$_connection ??= new self();
        return self::$_connection;
    }
}
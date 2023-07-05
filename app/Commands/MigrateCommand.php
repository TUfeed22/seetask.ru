<?php

namespace app\Commands;

use app\Database\Builder\PgSqlQueryBuilder;
use app\Database\Connection;
use app\Database\Database;
use app\Settings\Settings;
use app\Database\Migration;
use Exception;

class MigrateCommand extends Migration
{
    /**
     * Создание миграции
     * @param string|null $name Наименование файла
     * @return void
     * @throws Exception
     */
    public function actionCreate(string $name = null): void
    {
        $migrationPath = Settings::getConfig('app.php')->migrationsPath;
        $migrationFileName = $this->generateMigrationName($name);
        $migrationFilePath = $migrationPath . $migrationFileName . '.php';

        $this->createFile($migrationFilePath, $this->getTemplateMigration($migrationFileName));
    }

    /**
     * Применение миграции
     * @return void
     * @throws Exception
     */
    public function actionUp(): void
    {
        echo 'Проверяем существование таблицы ' . $this->getTableName() . PHP_EOL;
        // создаем таблицу, если она не создана
        $this->createTableMigrations();

        if (!Database::checkTable($this->getTableName())) {
            echo 'Таблица не создана!' . PHP_EOL;
        }

        // поиск новых миграций
        // применяем миграции, если они есть
        $this->applyMigration($this->searchNewMigrations());
    }

    /**
     * Откат миграции
     * @param $migration
     * @return void
     * @throws Exception
     */
    public function actionDown($migration): void
    {
        $pdo = Connection::db()->connection;
        $query = PgSqlQueryBuilder::createSql()
            ->select(['migration'])
            ->from($this->getTableName())
            ->where('migration', $migration, '=')
            ->build();
        $result = $pdo->prepare($query)->execute();
        $class = str_replace('/', '\\', 'app\\Database\\migrations\\' . $migration);
        call_user_func(array(new $class, 'down'));
    }
}
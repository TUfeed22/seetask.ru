<?php

namespace app\Commands;

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
     */
    public function actionUp(): void
    {
        $migrationsTableName = Settings::getConfig('app.php')->migrationsTableName;
        $migrationsPath = Settings::getConfig('app.php')->migrationsPath;

        // создаем таблицу, если она не создана
        $this->createTableMigrations($migrationsTableName);

        // поиск новых миграций
        $newMigrations = $this->searchNewMigrations($migrationsPath, $migrationsTableName);

        // применяем миграции, если они есть
        $this->applyMigration($migrationsPath, $newMigrations);
    }

    /**
     * Откат миграции
     * @return void
     */
    public function actionDown(): void
    {

    }
}
<?php

namespace app\Commands;

use app\Settings\Settings;
use app\Database\Migration;
use Exception;

class MigrateCommand extends Migration
{
    /**
     * Создание файла миграций
     * @param string|null $name Наименование файла
     * @return void
     * @throws Exception
     */
    public function actionCreate(string $name = null): void
    {
        $migrationPath = Settings::getConfig('app.php')->migratePath;
        $migrationFileName = $this->generateMigrationName($name);
        $migrationFilePath = $migrationPath . $migrationFileName . '.php';

        $this->createFile($migrationFilePath, $this->getTemplateMigration($migrationFileName));
    }

    public function actionUp()
    {

    }

    public function actionDown()
    {

    }
}
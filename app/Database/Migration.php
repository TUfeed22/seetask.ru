<?php

namespace app\Database;

use app\Settings\Settings;
use DateTime;
use Exception;

class Migration
{

    /**
     * Шаблон файла миграции
     * @param string $className Наименование класса, соответствует наименованию файла миграции
     * @return string
     */
    protected function getTemplateMigration(string $className): string
    {
        return '<?php' . PHP_EOL
            . 'namespace app\Database\migrations;' . PHP_EOL
            .  'class ' . $className . '{' . PHP_EOL

            . '    public function up()' . PHP_EOL
            . '    {' . PHP_EOL
            . '    }' . PHP_EOL

            . '    public function down()' . PHP_EOL
            . '    {' . PHP_EOL
            . '    }' . PHP_EOL
            . '}';
    }

    /**
     * Генерация имени файла миграции
     * @param string | null $name Пользовательское наименование, по умолчанию будет сгенерировано автоматически
     * @return string
     */
    protected function generateMigrationName(string $name = null): string
    {
        $createDate = new DateTime();
        $migrationFileName = 'm_' . $createDate->format('ymd_his');

        if ($name) {
            $migrationFileName .= '_' . $name;
        } else {
            $migrationFileName .= '_' . uniqid();
        }

        return $migrationFileName;
    }

    /**
     * Создания файла
     * @param $file
     * @param $body
     * @return void
     * @throws Exception
     */
    protected function createFile($file, $body): void
    {
        try {
            file_put_contents($file, $body);
        } catch (Exception $exception) {
            throw new Exception('Ошибка создания файла: ' . $exception->getMessage());
        }
    }

    /**
     * Создаем таблицу, если она не создана
     * @param $migrationsTableName
     * @return void
     */
    protected function createTableMigrations($migrationsTableName): void
    {
        // создаем таблицу, если она не создана
        if (!Database::checkTable($migrationsTableName)) {
            Database::createTable($migrationsTableName, ['migration' => 'varchar(255) NOT NULL']);
        }
    }

    /**
     * Поиск новых миграций
     * @param $migrationsPath
     * @param $migrationsTableName
     * @return array|bool
     */
    protected function searchNewMigrations($migrationsPath, $migrationsTableName): array|bool
    {
        $migrations = [];
        foreach (scandir($migrationsPath) as $migrationFile) {
            $migrations[] = basename($migrationFile, '.php');
        }
        return array_diff(Database::fetchAll($migrationsTableName), $migrations);
    }

    /**
     * Применяем миграции, если они есть
     * @param $migrationsPath
     * @param $newMigrations
     * @return void
     */
    protected function applyMigration($migrationsPath, $newMigrations): void
    {
        if ($newMigrations) {
            foreach ($newMigrations as $newMigration) {
                $class = str_replace('/', '\\', $migrationsPath . $newMigration);
                call_user_func(array(new $class, 'up'));
            }
        }
    }
}
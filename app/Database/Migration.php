<?php

namespace app\Database;

use app\Settings\Settings;
use DateTime;
use Exception;

class Migration
{
    /**
     * Каталог с миграциями
     * @return mixed
     */
    private function getTemplatePath(): mixed
    {
        return Settings::getConfig('app.php')->migrationsPath;
    }

    /**
     * Наименование таблицы с миграциями
     * @return mixed
     */
    protected function getTableName(): mixed
    {
        return Settings::getConfig('app.php')->migrationsTableName;
    }

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

        $migrationFileName .= $name ? '_' . $name : '_' . uniqid();

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
     * @return void
     */
    protected function createTableMigrations(): void
    {
        // создаем таблицу, если она не создана
        if (!Database::checkTable($this->getTableName())) {
            echo 'Таблица не существует. Создаем.' . PHP_EOL;
            Database::createTable($this->getTableName(), ['migration' => 'varchar(255) NOT NULL']);
        } else {
            echo 'Таблица существует.' . PHP_EOL;
        }
    }

    /**
     * Поиск новых миграций
     * @return array|bool
     */
    protected function searchNewMigrations(): array|bool
    {
        echo 'Поиск новых миграций' . PHP_EOL;
        $migrations = [];
        foreach (scandir($this->getTemplatePath()) as $migrationFile) {
            $migrations[] = basename($migrationFile, '.php');
        }
        if (!empty($migrations)) {
            array_splice($migrations, 0, 2);
            echo 'Миграции найдены' . PHP_EOL;
            print_r($migrations);
            echo PHP_EOL;
        }

        return array_diff(array_diff($migrations, Database::fetchAll($this->getTableName())));
    }

    /**
     * Применяем миграции, если они есть
     * @param $newMigrations
     * @return void
     */
    protected function applyMigration($newMigrations): void
    {
        if ($newMigrations) {
            foreach ($newMigrations as $migration) {
                echo "Применение миграции: " . $migration . PHP_EOL;
                $class = str_replace('/', '\\', 'app\\Database\\migrations\\' . $migration);
                call_user_func(array(new $class, 'up'));
                $this->saveMigrations($newMigrations);
            }
        }
    }

    /**
     * Сохранение миграции в БД
     * @param $migrations
     * @return void
     */
    private function saveMigrations($migrations): void
    {
        $pdo = Connection::db()->connection;
        $query = 'INSERT INTO migrations (migration) VALUES ';
        foreach ($migrations as $migration) {
            $query .= "('$migration')";
            $query .= array_key_last($migrations) != $migration ? ';' : ',';
        }
        $pdo->prepare($query)->execute();
    }
}
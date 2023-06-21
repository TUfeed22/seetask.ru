<?php

namespace app\Database;

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
}
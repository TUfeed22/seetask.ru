<?php
namespace Commands;
use DateTime;
use Exception;
use Database\Migrations;

class CommandMigration
{
  /**
   * Инициализация файла для миграции
   * @return void
   */
  public function init(): void
  {
    // проверяем существование директории с миграциями, если ее нет то создаем
    if (!file_exists('../Database/migrations')) {
      mkdir('../Database/migrations');
      echo "Создана директория" . PHP_EOL;
    } else {
      echo "Директория существует" . PHP_EOL;
    }

    // текущая дата и время
    $dataTime = new DateTime();

    // генерируем случайный текст
    $randomText = substr(md5(rand()), 0, 7);
    $fileNameMigration = $dataTime->format('Y_m_d_his') . '_' . $randomText . '.sql';
    
    // создаем пустой sql файл
    try{
      file_put_contents('../Database/migrations/' . $fileNameMigration, '');
      echo "Создан файл миграции: " . $fileNameMigration . PHP_EOL;
    } catch (Exception $e) {
      print_r("Возникла ошибка: " . $e->getMessage() . PHP_EOL);
    }
  }

  /**
   * Выполнение миграций
   * @return void
   */
  public function migrate(): void
  {
    $migration = new Migrations();
    // получаем массив с файлами миграций.
    $migrationFiles = glob(str_replace('\\', '/', realpath(dirname(__DIR__)) . '/Database/migrations/' . '*.sql'));
    
    // создаем таблицу с версиями миграций, если еще не создана.
    $tableMigrationVersions = $migration->createTableMigrationVersions();

    $getMigrationFiles = $migration->getMigrationFiles($tableMigrationVersions, $migrationFiles);
    if ($getMigrationFiles){
      echo "Начинаем миграцию:" . PHP_EOL;
      foreach ($getMigrationFiles as $file) {
        // выполняем миграции
        $query = file_get_contents(str_replace('\\', '/', realpath(dirname(__DIR__)) . '/Database/migrations/' . $file));
        if ($migration->executeQuery($query)){
          // сохраняем в таблицу
          $query = "INSERT INTO " . $migration::TABLE_MIGRATION_VERSIONS . "(version) values ('" . $file . "')";
          $migration->executeQuery($query);
          echo "  => " . $file . " ---> \033[32m ОК \033[0m" . PHP_EOL;
        } else {
          echo "  => " . $file . " ---> \033[31m ERROR \033[0m" . PHP_EOL;
        }
      }
      echo "Миграция завершена." . PHP_EOL;
    } else {
      echo "Миграции не найдены." . PHP_EOL;
    }
  }
}
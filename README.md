# Seetask - приложение для работы с задачами.
## Миграции
### 1. Миграция после разворачивания docker
  В консоли перейти в директорию ``` var/www/seetask/application/bin ``` и выполнить команду: ``` php cli.php migration migrate ```
  В этом случае выполнятся все файлы миграций, которые находятся в директории ``` var/www/seetask/application/Database/migrations ```

<?php

namespace app\Commands;

use app\Database\Builder\PgSqlQueryBuilder;
use app\Database\Database;
use app\Settings\Settings;
use DateTime;
use DateTimeZone;
use Exception;

class TestCommand
{
    /**
     * @throws Exception
     */
    public function actionTest(): void
    {
       echo substr_replace('test,', ');', -1, 1) . PHP_EOL;
    }
}
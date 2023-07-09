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
       echo PgSqlQueryBuilder::createSql()
           ->select(['id'])
           ->from('test')
           ->build() . PHP_EOL;
    }
}
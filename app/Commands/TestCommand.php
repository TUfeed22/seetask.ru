<?php

namespace app\Commands;

use app\Database\Builder\PgSqlQueryBuilder;
use app\Settings\Settings;
use DateTime;
use DateTimeZone;
use Exception;

class TestCommand
{
    /**
     * @throws Exception
     */
    public function actionHello(): void
    {
        echo PgSqlQueryBuilder::createSql()
                ->insert('users')
                ->values(['username'], [['tufeed2345']])
                ->build() . PHP_EOL;
    }
}
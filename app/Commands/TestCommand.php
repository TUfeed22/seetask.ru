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
        $query = new PgSqlQueryBuilder();
        echo $query->select(['*'])
                ->from('users')
                ->where('id', 4, '>')
                ->where('id', 4, '<')
                ->build() . PHP_EOL;
    }
}
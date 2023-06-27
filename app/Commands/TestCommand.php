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
                ->select(['*'])
                ->from('users')
                ->join('users', 'users.id', 'users.id', 'LEFT')
                ->join('test', 'test.id', 'users.id')
                ->where('id', 4, '>')
                ->where('id', 4, '<')
                ->build() . PHP_EOL;

        echo PgSqlQueryBuilder::createSql()
                ->select(['id, name'])
                ->from('users')
                ->join('test', 'test.id', 'users.id')
                ->where('id', 24, '>')
                ->build() . PHP_EOL;
    }
}
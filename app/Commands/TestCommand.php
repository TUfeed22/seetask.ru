<?php

namespace app\Commands;

use app\Settings\Settings;
use DateTime;
use DateTimeZone;

class TestCommand
{
    public function actionHello(): void
    {
        $data = new DateTime();
        $data->setTimezone(new DateTimeZone('+0300'));

        $hash = md5($data->format('y-m-d h:i:m') . rand(1,10), 5);
        echo $hash . PHP_EOL;
    }
}
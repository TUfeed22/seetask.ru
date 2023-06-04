<?php

namespace Settings;

use PHPUnit\Framework\TestCase;
use app\Settings\Settings;

class GetConfigFileTest extends TestCase
{
    protected function setUp(): void
    {
        file_put_contents('/var/www/seetask.ru/app/config/test.php', '');
    }

    /**
     * @test
     * @covers Settings::getConfig
     * @covers Settings::fileConfigurationEmpty
     * @covers Settings::fileConfigurationExists
     * @return void
     */
    public function testGetConfigFile(): void
    {
        $this->assertIsObject(Settings::getConfig('app.php'));
        $this->assertIsObject(Settings::getConfig('database.php'));
        $this->assertNull(Settings::getConfig('exists.php'));
        $this->assertNull(Settings::getConfig('test.php'));
    }
    protected function tearDown(): void
    {
        unlink('/var/www/seetask.ru/app/config/test.php');
    }

}

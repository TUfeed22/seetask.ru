<?php

namespace Settings;

use app\Settings\Settings;
use PHPUnit\Framework\TestCase;

class GetConfigAppTest extends TestCase
{
    private string $pathToConfigFile = '/var/www/seetask.ru/app/config/';

    /**
     * @covers
     * @return string
     */
    public function testFileExistsApp(): string
    {
        $fileName = 'app.php';
        $patch = $this->pathToConfigFile . $fileName;
        $this->assertFileExists($patch);
        return $fileName;

    }

    /**
     * @depends testFileExistsApp
     * @test
     * @covers  Settings::getConfig
     * @param string $filename
     * @return void
     */
    public function testGetConfig(string $filename): void
    {
        $getConfig = Settings::getConfig($filename);
        $this->assertNotEmpty($getConfig);
    }

}

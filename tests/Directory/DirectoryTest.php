<?php

namespace Directory;

use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
    /**
     * @covers
     * @return void
     */
    public function testDirectoryExists(): void
    {
        $this->assertDirectoryExists('/var/www/seetask.ru');
        $this->assertDirectoryExists('/var/www/seetask.ru/app/config');
    }
}

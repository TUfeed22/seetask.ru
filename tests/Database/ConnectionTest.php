<?php

namespace Database;
use app\Database\Connection;
use PHPUnit\Framework\TestCase;
use PDO;

class ConnectionTest extends TestCase
{
    protected $connectionOne;
    protected $connectionTwo;

    protected function setUp(): void
    {
        $this->connectionOne = Connection::db()->connection;
        $this->connectionTwo = Connection::db()->connection;
    }

    /**
     * @test
     * @covers
     * @return void
     */
    public function testDbConnection(): void
    {
        $this->assertInstanceOf(PDO::class, $this->connectionOne);
        $this->assertSame($this->connectionOne, $this->connectionTwo);
    }

}

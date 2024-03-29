<?php

namespace Config;

use App\Config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConnection()
    {
        $connection = Database::getConnection();
        self::assertNotNull($connection);
    }

    public function testGetConnectionSingleton()
    {
        $connection = Database::getConnection();
        $connection2 = Database::getConnection();
        self::assertSame($connection, $connection2);
    }

}
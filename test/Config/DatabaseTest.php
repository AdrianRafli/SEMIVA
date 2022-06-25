<?php
namespace Adrian\Website\Semiva\Config;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConnection() {
        $connection = Database::getConnection();
        // Pastikan Koneksi Tidak Null
        self::assertNotNull($connection);
    }

    public function testGetConnectionSingLeton() {
        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();
        // pastikan kedua object ini adalah koneksi yang sama
        self::assertSame($connection1, $connection2);
    }
}
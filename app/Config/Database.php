<?php

namespace App\Config;

class Database
{
    private static ?\PDO $pdo = null;

    public static function getConnection(string $env ="test"): \PDO {
        if (self::$pdo === null) {
            // Create new PDO connection
            require_once __DIR__ . "/../../config/database.php";
            $config = getDatabaseConfig();
            self::$pdo = new \PDO(
                $config["database"][$env]["url"],
                $config["database"][$env]["username"],
                $config["database"][$env]["password"]
            );
        }

        return self::$pdo;
    }

    public static function begin(): void
    {
        self::$pdo->beginTransaction();
    }

    public static function commit(): void
    {
        self::$pdo->commit();
    }

    public static function rollBack(): void
    {
        self::$pdo->rollBack();
    }
}
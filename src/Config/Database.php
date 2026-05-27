<?php

declare(strict_types=1);

namespace Todoitapi\App\Config;

use PDO;
class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO{
        if(self::$instance === null){
            self::$instance = new PDO(
                dsn: $_ENV['DB_DSN'],
                username: $_ENV['DB_NAME'] ?? 'root',
                password: $_ENV['DB_PASSWORD'] ?? '',
                options: [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                ],
            );
        }
        return self::$instance;
    }
}
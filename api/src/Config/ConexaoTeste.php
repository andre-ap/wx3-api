<?php

declare(strict_types=1);

namespace Src\Config;

use Dotenv\Dotenv;
use PDO;

class ConexaoTeste
{
    private static ?PDO $pdo = null;

    public static function conectar(): PDO
    {
        $path_env = __DIR__ . "/../../../";
        $dotenv = Dotenv::createImmutable($path_env);
        $dotenv->load();
        $DB_DATABASE = $_ENV['DB_TESTE'];
        $DB_PORT = $_ENV['DB_PORT'];
        $DB_HOST = $_ENV['DB_HOST'];
        $DB_USER = $_ENV['DB_USER'];
        $DB_PASSWORD = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:dbname=$DB_DATABASE;port=$DB_PORT;host=$DB_HOST;charset=utf8";

        self::$pdo = new PDO(
            $dsn,
            $DB_USER,
            $DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        return self::$pdo;
    }
}

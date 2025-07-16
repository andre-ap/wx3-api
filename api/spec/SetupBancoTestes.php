<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\ConexaoTeste;

class SetupBancoTestes
{

    public static function setup(): void
    {
        self::montarBanco();
        self::inserirDados();
    }

    private static function montarBanco(): void
    {
        $pdo = self::conectarSemBanco();

        $sql = file_get_contents(__DIR__ . "/../../docs/bd_teste.sql");
        if ($sql === false) {
            throw new Exception("Arquivo bd_teste.sql não encontrado ou vazio");
        }

        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao montar o banco: ' . $e->getMessage();
            throw $e;
        }
    }

    private static function inserirDados(): void
    {
        $pdo = ConexaoTeste::conectar();
        $sql  = file_get_contents(__DIR__ . "/../../docs/seed_teste.sql");
        if ($sql === false) {
            throw new Exception("Arquivo seed_teste.sql não encontrado ou vazio");
        }
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao inserir dados' . $e->getMessage();
        }
    }

    public static function excluirTabelasBanco(): void
    {
        $pdo = ConexaoTeste::conectar();
        $sql  = file_get_contents(__DIR__ . "/../../docs/drop_database.sql");
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao excluir tabelas: ' . $e->getMessage();
            throw $e;
        }
    }

    private static function conectarSemBanco(): PDO
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$host;port=$port;charset=utf8";

        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}

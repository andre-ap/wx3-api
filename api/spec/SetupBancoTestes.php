<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\ConexaoDB;

class SetupBancoTestes
{

    public static function setup(): void
    {
        self::montarBanco();
        self::inserirDados();
    }

    private static function montarBanco(): void
    {
        $pdo = ConexaoDB::conectar();
        $sql  = file_get_contents(__DIR__ . "/../../docs/bd_teste.sql");
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao montar o banco' . $e;
        }
    }

    private static function inserirDados(): void
    {
        $pdo = ConexaoDB::conectar();
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
        $pdo = ConexaoDB::conectar();
        $sql  = file_get_contents(__DIR__ . "/../../docs/drop_database.sql");
        try {
            $pdo->exec($sql);
        } catch (PDOException $e) {
            echo 'Erro ao excluir tabelas: ' . $e->getMessage();
            throw $e;
        }
    }
}

<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Variacao;

class VariacaoDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarVariacoes(): array
    {
        $ps = $this->pdo->query("SELECT id, produto_id, tamanho, estoque, preco FROM variacoes");

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        $variacoes = [];

        foreach ($dados as $linha) {
            $variacoes[] = new Variacao($linha);
        }

        return $variacoes;
    }

    public function buscarVariacaoPorId ($id): Variacao
    {
        $sql = "SELECT id, produto_id, tamanho, estoque, preco 
                FROM variacoes
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        $variacao = $ps->fetch(PDO::FETCH_ASSOC);

        return new Variacao($variacao);
    }

    public function criarNovaVariacao (array $dados): int
    {
        $sql = "INSERT INTO variacoes (produto_id, tamanho, estoque, preco)
                VALUES (:produto_id, :tamanho, :estoque, :preco)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':produto_id' => $dados['produto_id'],
            ':tamanho' => $dados['tamanho'],
            ':estoque' => $dados['estoque'],
            ':preco' => $dados['preco']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function atualizarVariacao (int $id, array $dados): int {
        $sql = "UPDATE variacoes SET produto_id = :produto_id, tamanho = :tamanho,
                estoque = :estoque, preco = :preco
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':produto_id' => $dados['produto_id'],
            ':tamanho' => $dados['tamanho'],
            ':estoque' => $dados['estoque'],
            ':preco' => $dados['preco'],
            ':id' => $id
        ]);

        return $id;
    }

    public function removerVariacaoPorId (int $id): int 
    {
        $sql = "DELETE FROM variacoes WHERE id = :id";
        
        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        return $id;
    }
}

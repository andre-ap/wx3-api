<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Variacao;

class VariacaoDAO implements VariacaoDAOInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Variacao[]
     */
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
            $variacoes[] = new Variacao(
                id: $linha["id"],
                produtoId: $linha["produto_id"],
                tamanho: $linha["tamanho"],
                estoque: $linha["estoque"],
                preco: $linha["preco"],
            );
        }

        return $variacoes;
    }

    /**
     * @param int $id
     * @return Variacao|null
     */
    public function buscarVariacaoPorId($id): Variacao|null
    {
        $sql = "SELECT id, produto_id, tamanho, estoque, preco 
                FROM variacoes
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        $variacao = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$variacao) {
            return null;
        }

        return new Variacao(
            id: $variacao["id"],
            produtoId: $variacao["produto_id"],
            tamanho: $variacao["tamanho"],
            estoque: $variacao["estoque"],
            preco: $variacao["preco"],
        );
    }

    /**
     * @param Variacao $variacao
     * @return int
     */
    public function criarNovaVariacao(Variacao $variacao): int
    {
        $sql = "INSERT INTO variacoes (produto_id, tamanho, estoque, preco)
                VALUES (:produto_id, :tamanho, :estoque, :preco)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':produto_id' => $variacao->produtoId,
            ':tamanho' => $variacao->tamanho,
            ':estoque' => $variacao->estoque,
            ':preco' => $variacao->preco
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array{
     * produtoId: int,
     * tamanho: string,
     * estoque: int,
     * preco: float
     * } $dados
     * @return int
     */
    public function atualizarVariacao(int $id, array $dados): int
    {
        $sql = "UPDATE variacoes SET produto_id = :produto_id, tamanho = :tamanho,
                estoque = :estoque, preco = :preco
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':produto_id' => $dados['produtoId'],
            ':tamanho' => $dados['tamanho'],
            ':estoque' => $dados['estoque'],
            ':preco' => $dados['preco'],
            ':id' => $id
        ]);

        return $id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerVariacaoPorId(int $id): int
    {
        $sql = "DELETE FROM variacoes WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        return $id;
    }
}

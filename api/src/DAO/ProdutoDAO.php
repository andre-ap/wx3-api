<?php

namespace Src\DAO;

use DateTime;
use Exception;
use PDO;
use Src\Model\Produto;

class ProdutoDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Produto[]
     */
    public function buscarProdutos(): array
    {

        $ps = $this->pdo->query("SELECT id, nome, cor, imagem, preco_base, descricao, data_cadastro, peso, categoria_id FROM produtos");

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        $produtos = [];

        foreach ($dados as $linha) {
            $produtos[] = new Produto($linha);
        }

        return $produtos;
    }

    /**
     * @return Produto | array<void>
     */
    public function buscarProdutoPorId(int $id): Produto | array
    {

        $sql = "SELECT id, nome, cor, imagem, preco_base, descricao, data_cadastro, peso, categoria_id FROM produtos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute(['id' => $id]);

        $dados = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        return new Produto($dados);
    }

    /**
     * @param Produto $produto
     * @return int
     */
    public function inserirProduto(Produto $produto): int
    {
        $data = new DateTime();
        $dataString = $data->format('Y/m/d');
        $sql = "INSERT INTO produtos (nome, cor, imagem, preco_base, descricao, data_cadastro, peso, categoria_id)
            VALUES (:nome, :cor, :imagem, :preco, :descricao, :data_cadastro, :peso, :categoria_id)";

        $ps = $this->pdo->prepare($sql);
        $ps->execute([
            ':nome' => $produto->nome,
            ':cor' => $produto->cor,
            ':imagem' => $produto->imagem,
            ':preco' => $produto->preco,
            ':descricao' => $produto->descricao,
            ':data_cadastro' => $dataString,
            ':peso' => $produto->peso,
            ':categoria_id' => $produto->categoriaId
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco_base: float,
     *   descricao: string,
     *   dataCadastro: string,
     *   peso: float,
     *   categoria_id: int
     * } $dados
     * @return int
     */
    public function atualizarProduto(int $id, array $dados): int
    {
        $sql =
            "UPDATE produtos SET
                nome = :nome,
                cor = :cor,
                imagem = :imagem,
                preco_base = :preco_base,
                descricao = :descricao,
                data_cadastro = :data_cadastro,
                peso = :peso,
                categoria_id = :categoria_id
            WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':nome' => $dados['nome'],
            ':cor' => $dados['cor'],
            ':imagem' => $dados['imagem'],
            ':preco_base' => $dados['preco_base'],
            ':descricao' => $dados['descricao'],
            ':peso' => $dados['peso'],
            ':data_cadastro' => $dados['dataCadastro'],
            ':categoria_id' => $dados['categoria_id'],
            ':id' => $id
        ]);

        return $id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerProduto(int $id): int
    {
        $sql = "DELETE FROM produtos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute(['id' => $id]);

        return $id;
    }
}

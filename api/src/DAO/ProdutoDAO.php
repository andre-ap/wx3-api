<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Exception\ProdutoException;
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
        try {
            $ps = $this->pdo->query("
            SELECT id, nome, cor, imagem, preco_base, descricao, data_cadastro, peso, categoria_id
            FROM produtos
        ");
            if (!$ps) {
                throw new Exception("SQL mal formatada ou erro ao executar");
            }

            $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

            $produtos = [];

            foreach ($dados as $linha) {
                $produtos[] = new Produto($linha);
            }

            return $produtos;
        } catch (\PDOException $e) {
            throw new \RuntimeException('Erro ao acessar o banco de dados', 500, $e);
        }
    }

    /**
     * @return Produto
     */
    public function buscarProdutoPorId(int $id): Produto | null
    {
        try {
            $sql = "SELECT id, nome, cor, imagem, preco_base, descricao, data_cadastro, peso, categoria_id FROM produtos WHERE id = :id";
            $ps = $this->pdo->prepare($sql);
            $ps->execute(['id' => $id]);

            $dados = $ps->fetch(PDO::FETCH_ASSOC);

            if (!$dados){
                return null;
            }

            return new Produto($dados);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Erro ao acessar o banco de dados', 500, $e);
        }
    }
}

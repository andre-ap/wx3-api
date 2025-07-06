<?php

namespace Src\DAO;

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
     * Summary of buscarProdutos
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
                throw ProdutoException::erroAoMontarObjeto(["Query mal escrita ou falha na execução."]);
            }

            $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

            $produtos = [];

            foreach ($dados as $linha) {
                $produtos[] = new Produto($linha);
            }

            return $produtos;

        } catch (\PDOException $e) {
            throw ProdutoException::erroAoAcessarBD();
        }
    }
}
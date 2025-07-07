<?php

namespace Src\Service;

use PDO;
use Src\DAO\ProdutoDAO;
use Src\Model\Produto;

class ProdutoService
{
    private ProdutoDAO $dao;

    public function __construct(PDO $pdo)
    {
        $this->dao = new ProdutoDAO($pdo);
    }

    /**
     * @return Produto[]
     */
    public function listarTodosProdutos()
    {
        return $this->dao->buscarProdutos();
    }

    /**
     * @return Produto
     */
    public function buscarProdutoPorId(int $id): Produto | null
    {
        return $this->dao->buscarProdutoPorId($id);
    }

    /**
     * Summary of __construct
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco_base: float,
     *   descricao: string,
     *   data_cadastro: string | null,
     *   peso: float,
     *   categoria_id: int
     * } $dados
     * @return int
     */
    public function criarNovoProduto(array $dados): int
    {
        // TODO -> fazer validações
        $produto = new Produto($dados);
        return $this->dao->inserirProduto($produto);
    }

    public function atualizarProduto(int $id, array $dados): int {
        $this->dao->atualizarProduto($id, $dados);
        return (int) $id;
    }
}

<?php

namespace Src\Service;

use PDO;
use Src\DAO\ProdutoDAO;
use Src\Model\Produto;

class ProdutoService {
    private ProdutoDAO $dao;

    public function __construct (PDO $pdo) {
        $this->dao = new ProdutoDAO($pdo);
    }

    /**
     * @return Produto[]
     */
    public function listarTodosProdutos () {
        return $this->dao->buscarProdutos();
    }

    /**
     * @return Produto
     */
    public function buscarProdutoPorId(int $id): Produto | null {
        return $this->dao->buscarProdutoPorId($id);
    }
}
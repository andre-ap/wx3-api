<?php

namespace Src\Controller;

use PDO;
use Src\Service\ProdutoService;
use Src\Model\Produto;

class ProdutoController {

    private ProdutoService $service;

    public function __construct (PDO $pdo) {
        $this->service = new ProdutoService ($pdo);
    }

    /**
     * @return Produto[]
     */
    public function listar (): array {
        return $this->service->listarTodosProdutos();
    }

    /**
     * @return Produto|null
     */
    public function buscar (int $id): Produto|null {
        
        return $this->service->buscarProdutoPorId($id);
    }
}
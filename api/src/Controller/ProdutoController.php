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
     * Summary of listar
     * @return Produto[]
     */
    public function listar (): array {
        return $this->service->listarTodosProdutos();
    }
}
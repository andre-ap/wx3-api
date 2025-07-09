<?php

namespace Src\Controller;

use PDO;
use Src\Service\VariacaoService;

class VariacaoController
{

    private VariacaoService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new VariacaoService($pdo);
    }

    /**
     * @return Variacao[]
     */
    public function listar()
    {
        return $this->service->listarVariacoes();
    }

    public function buscar(int $id)
    {
        return $this->service->buscarVariacaoPorId($id);
    }

    public function criar (array $dados): int {
        return $this->service->criarNovaVariacao($dados);
    }

    public function atualizar (int $id, array $dados): int {
        return $this->service->atualizarVariacao($id, $dados);
    }

    public function remover (int $id): int 
    {
        return $this->service->removerVariacaoPorId($id);
    }
}

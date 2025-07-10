<?php

namespace Src\Controller;

use PDO;
use Src\Model\Variacao;
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

    /**
     * @param int $id
     * @return Variacao|null
     */
    public function buscar(int $id)
    {
        return $this->service->buscarVariacaoPorId($id);
    }

    /**
     * @param array{
     * produtoId: int,
     * tamanho: string,
     * estoque: int,
     * preco: float
     * } $dados
     * @return int
     */
    public function criar(array $dados): int
    {
        return $this->service->criarNovaVariacao($dados);
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
    public function atualizar(int $id, array $dados): int
    {
        return $this->service->atualizarVariacao($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function remover(int $id): int
    {
        return $this->service->removerVariacaoPorId($id);
    }
}

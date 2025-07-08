<?php

namespace Src\Controller;

use PDO;
use Src\Service\CategoriaService;
use Src\Model\Categoria;

class CategoriaController
{

    private CategoriaService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new CategoriaService($pdo);
    }

    /**
     * @return Categoria[]
     */
    public function listar(): array
    {
        return $this->service->listarTodasCategorias();
    }

    /**
     * @param int $id
     * @return Categoria | array<void>
     */
    public function buscar(int $id): Categoria | array
    {
        return $this->service->buscarCategoriaPorId($id);
    }

    /**
     * @param array{
     * id: int,
     * nome: string,
     * descricao: string
     * } $dados
     * @return int
     */
    public function criar(array $dados): int
    {
        return $this->service->criarNovaCategoria($dados);
    }

    /**
     * @param int $id
     * @param array{
     * id: int,
     * nome: string,
     * descricao: string
     * } $dados
     * @return int
     */
    public function atualizar (int $id, array $dados): int {
        return $this->service->atualizarCategoria($id, $dados);
    }
 
    /**
     * @param int $id
     * @return int
     */
    public function remover (int $id): int
    {
        return $this->service->removerItemPorID($id);
    }
}

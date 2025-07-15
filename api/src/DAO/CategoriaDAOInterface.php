<?php

namespace Src\DAO;

use Src\Model\Categoria;

interface CategoriaDAOInterface
{
    /**
     * @return Categoria[]
     */
    public function buscarCategorias(): array;

    /**
     * @param int $id
     * @return Categoria | array<void>
     */
    public function buscarCategoriaPorId(int $id): Categoria | array;

    public function criarNovaCategoria(Categoria $categoria): int;

    /**
     * @param int $id
     * @param array{nome: string, descricao: string} $dados
     */
    public function atualizarCategoria(int $id, array $dados): int;

    public function removerItemPorID(int $id): int;
}

<?php

namespace Src\DAO;

use Src\Model\Categoria;

interface CategoriaDAOInterface
{
    public function buscarCategorias(): array;
    public function buscarCategoriaPorId(int $id): Categoria | array;
    public function criarNovaCategoria(Categoria $categoria): int;
    public function atualizarCategoria(int $id, array $dados): int;
    public function removerItemPorID(int $id): int;
}

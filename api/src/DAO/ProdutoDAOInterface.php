<?php
namespace Src\DAO;

use Src\Model\Produto;

interface ProdutoDAOInterface
{
    /** @return Produto[] */
    public function buscarProdutos(): array;

    public function buscarProdutoPorId(int $id): Produto|array;

    public function inserirProduto(Produto $produto): int;

    public function atualizarProduto(int $id, array $dados): int;

    public function removerProduto(int $id): int;
}
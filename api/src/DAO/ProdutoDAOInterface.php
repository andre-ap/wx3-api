<?php
namespace Src\DAO;

use Src\Model\Produto;

interface ProdutoDAOInterface
{
    /** @return Produto[] */
    public function buscarProdutos(): array;

    /**
     * @return Produto | array<void>
     */
    public function buscarProdutoPorId(int $id): Produto|array;

    public function inserirProduto(Produto $produto): int;

    /**
     * @param int $id
     * @param array{
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco: float,
     *   descricao: string,
     *   peso: float,
     *   categoriaId: int
     * } $dados
     */
    public function atualizarProduto(int $id, array $dados): int;

    public function removerProduto(int $id): int;
}
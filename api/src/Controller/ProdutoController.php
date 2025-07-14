<?php

namespace Src\Controller;

use PDO;
use Src\DAO\CategoriaDAO;
use Src\DAO\ProdutoDAO;
use Src\Service\ProdutoService;
use Src\Model\Produto;
use Src\Service\CategoriaService;

class ProdutoController
{

    private ProdutoService $service;

    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Produto[]
     */
    public function listar(): array
    {
        return $this->service->listarTodosProdutos();
    }

    /**
     * @param int $id
     * @return Produto | array <void>
     */
    public function buscar(int $id): Produto | array
    {
        return $this->service->buscarProdutoPorId($id);
    }

    /**
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco: float,
     *   descricao: string,
     *   dataCadastro: string | null,
     *   peso: float,
     *   categoriaId: int
     * } $dados
     * @return int
     */
    public function criar(array $dados): int
    {
        return $this->service->criarNovoProduto($dados);
    }

    /**
     * @param int $id
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco: float,
     *   descricao: string,
     *   dataCadastro: string,
     *   peso: float,
     *   categoriaId: int
     * } $dados
     */
    public function atualizar(int $id, array $dados): int
    {
        return $this->service->atualizarProduto($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function remover(int $id): int
    {
        return $this->service->removerProduto($id);
    }
}

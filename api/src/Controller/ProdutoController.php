<?php

namespace Src\Controller;

use PDO;
use Src\Service\ProdutoService;
use Src\Model\Produto;

class ProdutoController
{

    private ProdutoService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new ProdutoService($pdo);
    }

    /**
     * @return Produto[]
     */
    public function listar(): array
    {
        return $this->service->listarTodosProdutos();
    }

    /**
     * @return Produto | array <void>
     */
    public function buscar(int $id): Produto | array
    {
        return $this->service->buscarProdutoPorId($id);
    }

    /**
     * Summary of __construct
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco_base: float,
     *   descricao: string,
     *   data_cadastro: string | null,
     *   peso: float,
     *   categoria_id: int
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
     *   preco_base: float,
     *   descricao: string,
     *   dataCadastro: string,
     *   peso: float,
     *   categoria_id: int
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

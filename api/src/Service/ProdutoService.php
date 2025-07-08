<?php

namespace Src\Service;

use PDO;
use Src\DAO\ProdutoDAO;
use Src\Exception\ProdutoException;
use Src\Model\Produto;
use Src\Service\CategoriaService;

class ProdutoService
{
    private ProdutoDAO $dao;
    private CategoriaService $categoriaService;

    public function __construct(PDO $pdo)
    {
        $this->dao = new ProdutoDAO($pdo);
        $this->categoriaService = new CategoriaService($pdo);
    }

    /**
     * @return Produto[]
     */
    public function listarTodosProdutos()
    {
        return $this->dao->buscarProdutos();
    }

    /**
     * @return Produto | array<void>
     */
    public function buscarProdutoPorId(int $id): Produto | array
    {
        $this->validarId($id);

        $produto = $this->dao->buscarProdutoPorId($id);

        if (!$produto) {
            throw new ProdutoException("Produto com ID $id não encontrado", 404);
        }

        return $produto;
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
    public function criarNovoProduto(array $dados): int
    {
        $this->validarDados($dados);

        $produto = new Produto($dados);

        return $this->dao->inserirProduto($produto);
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
    public function atualizarProduto(int $id, array $dados): int
    {
        $this->validarId($id);

        $this->validarDados($dados);

        $produto = $this->buscarProdutoPorId($id);

        if (!$produto) {
            throw ProdutoException::produtoInexistente($id);
        }

        return $this->dao->atualizarProduto($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerProduto(int $id): int
    {
        $this->validarId($id);

        $produto = $this->buscarProdutoPorId($id);

        if (!$produto) {
            throw ProdutoException::produtoInexistente($id);
        }

        return $this->dao->removerProduto($id);
    }

    /**
      * @param array<string, mixed> $dados
      * @return void
     */
    public function validarDados(array $dados): void
    {
        if (empty($dados['nome']) || strlen($dados['nome']) < 2) {
            throw ProdutoException::nomeInvalido();
        }

        if (empty($dados['cor']) || strlen($dados['cor']) < 3) {
            throw ProdutoException::corInvalida();
        }

        if (!isset($dados['preco_base']) || !is_numeric($dados['preco_base']) || $dados['preco_base'] <= 0) {
            throw ProdutoException::precoInvalido();
        }

        if (empty($dados['descricao']) || strlen($dados['descricao']) < 5) {
            throw ProdutoException::descricaoInvalida();
        }

        if (!isset($dados['peso']) || !is_numeric($dados['peso']) || $dados['peso'] <= 0) {
            throw ProdutoException::pesoInvalido();
        }

        if (!isset($dados['categoria_id']) || !is_numeric($dados['categoria_id'])) {
            throw ProdutoException::categoriaInvalida();
        }

        $categoria = $this->categoriaService->buscarCategoriaPorId((int)$dados['categoria_id']);

        if (!$categoria) {
            throw ProdutoException::categoriaInexistente((int)$dados['categoria_id']);
        }

        // Validar Data
    }

    /**
     * @param int $id
     * @return void
     */
    public function validarId(int $id): void
    {
        if ($id <= 0) {
            throw ProdutoException::idInvalido();
        }
    }
}

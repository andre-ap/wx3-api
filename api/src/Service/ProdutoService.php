<?php

namespace Src\Service;

use DateTime;
use PDO;
use Src\DAO\ProdutoDAOInterface;
use Src\Exception\ProdutoException;
use Src\Model\Produto;
use Src\Service\CategoriaService;

class ProdutoService
{
    private ProdutoDAOInterface $dao;
    private CategoriaService $categoriaService;

    public function __construct(ProdutoDAOInterface $produtoDAO, CategoriaService $categoriaService)
    {
        $this->dao = $produtoDAO;
        $this->categoriaService = $categoriaService;
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
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   descricao: string,
     *   peso: float,
     *   categoriaId: int
     * } $dados
     * @return int
     */
    public function criarNovoProduto(array $dados): int
    {
        $this->validarDados($dados);

        $data = new DateTime();
        $dataFormatada = $data->format("Y-m-d");

        $produto = new Produto(
            nome: $dados['nome'],
            cor: $dados['cor'],
            imagem: $dados['imagem'],
            descricao: $dados['descricao'],
            dataCadastro: $dataFormatada,
            peso: $dados['peso'],
            categoria: $dados['categoriaId']
        );

        return $this->dao->inserirProduto($produto);
    }

    /**
     * @param int $id
     * @param array{
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   descricao: string,
     *   peso: float,
     *   categoriaId: int
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
     * @param array{
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   descricao: string,
     *   peso: float,
     *   categoriaId: int
     * } $dados
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

        if (empty($dados['descricao']) || strlen($dados['descricao']) < 5) {
            throw ProdutoException::descricaoInvalida();
        }

        if ($dados['peso'] <= 0) {
            throw ProdutoException::pesoInvalido();
        }

        if ($dados['categoriaId'] <= 0) {
            throw ProdutoException::categoriaInvalida();
        }

        $categoria = $this->categoriaService->buscarCategoriaPorId((int)$dados['categoriaId']);

        if (!$categoria) {
            throw ProdutoException::categoriaInexistente((int)$dados['categoriaId']);
        }
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

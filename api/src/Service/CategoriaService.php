<?php

namespace Src\Service;

use PDO;
use Src\DAO\CategoriaDAO;
use Src\Model\Categoria;
use Src\Exception\CategoriaException;

class CategoriaService
{
    private CategoriaDAO $dao;

    public function __construct(PDO $pdo)
    {
        $this->dao = new CategoriaDAO($pdo);
    }

    /**
     * @return Categoria[]
     */
    public function listarTodasCategorias(): array
    {
        return $this->dao->buscarCategorias();
    }

    /**
     * @param int $id
     * @return Categoria | array<void>
     */
    public function buscarCategoriaPorId(int $id): Categoria | array
    {
        $this->validarId($id);

        $categoria = $this->dao->buscarCategoriaPorId($id);

        if (!$categoria) {
            throw CategoriaException::naoEncontrada($id);
        }

        return $categoria;
    }

    /**
     * @param array{
     * id: int,
     * nome: string,
     * descricao: string
     * } $dados
     * @return int
     */
    public function criarNovaCategoria(array $dados): int
    {
        $this->validarDados($dados);

        $categoria = new Categoria($dados);

        return $this->dao->criarNovaCategoria($categoria);
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
    public function atualizarCategoria(int $id, array $dados): int
    {
        $this->validarId($id);

        $this->validarDados($dados);

        $categoria = $this->dao->buscarCategoriaPorId($id);

        if (!$categoria) {
            throw CategoriaException::categoriaInexistente();
        }

        return $this->dao->atualizarCategoria($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerItemPorID(int $id): int
    {
        $this->validarId($id);

        $categoria = $this->buscarCategoriaPorId($id);

        if (!$categoria) {
            throw CategoriaException::categoriaInexistente();
        }

        return $this->dao->removerItemPorID($id);
    }

    /**
     * @param int $id
     * @return void
     */
    public function validarId(int $id): void
    {
        if ($id <= 0) {
            throw CategoriaException::idInvalido();
        }
    }

    /**
     * @param array{
     * id: int,
     * nome: string,
     * descricao: string
     * } $dados
     * @return void
     */
    public function validarDados(array $dados): void
    {
        if (empty($dados['nome']) || strlen($dados['nome']) < 2) {
            throw CategoriaException::nomeInvalido();
        }

        if (empty($dados['descricao']) || strlen($dados['descricao']) < 5) {
            throw CategoriaException::descricaoInvalida();
        }
    }
}

<?php

namespace Src\Service;

use Src\DAO\VariacaoDAOInterface;
use Src\Exception\VariacaoException;
use Src\Model\Variacao;

class VariacaoService
{
    private VariacaoDAOInterface $dao;

    public function __construct(VariacaoDAOInterface $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @return Variacao[]
     */
    public function listarVariacoes(): array
    {
        return $this->dao->listarVariacoes();
    }

    /**
     * @param int $id
     * @return Variacao|null
     */
    public function buscarVariacaoPorId(int $id): Variacao|null
    {
        $this->validarId($id);

        return $this->dao->buscarVariacaoPorId($id);
    }

    /**
     * @param array{
     * produtoId: int,
     * tamanho: string,
     * estoque: int,
     * } $dados
     * @return int
     */
    public function criarNovaVariacao(array $dados): int
    {
        $this->validarDados($dados);

        $variacao = new Variacao(
            produtoId: $dados["produtoId"],
            tamanho: $dados["tamanho"],
            estoque: $dados["estoque"],
        );

        return $this->dao->criarNovaVariacao($variacao);
    }

    /**
     * @param int $id
     * @param array{
     * produtoId: int,
     * tamanho: string,
     * estoque: int,
     * } $dados
     * @return int
     */
    public function atualizarVariacao(int $id, array $dados): int
    {
        $this->validarId($id);
        $this->validarDados($dados);

        return $this->dao->atualizarVariacao($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerVariacaoPorId(int $id): int
    {
        return $this->dao->removerVariacaoPorId($id);
    }

    public function validarId(int $id): void
    {
        if ($id <= 0) {
            throw VariacaoException::idInvalido();
        }
    }

    /**
     * @param array{
     * produtoId: int,
     * tamanho: string,
     * estoque: int,
     * } $dados
     * @return void
     */
    public function validarDados(array $dados): void
    {
        if ($dados['produtoId'] <= 0) {
            throw VariacaoException::produtoIdInvalido();
        }

        if (strlen($dados['tamanho']) < 1 || strlen($dados['tamanho']) > 10) {
            throw VariacaoException::tamanhoInvalido();
        }

        if ($dados['estoque'] < 0) {
            throw VariacaoException::estoqueInvalido();
        }
    }
  
    public function buscarPreco (int $id): float 
    {
        return $this->dao->buscarPrecoVariacao($id);
    }
}

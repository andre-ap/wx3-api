<?php

namespace Src\DAO;

use Src\Model\Variacao;

interface VariacaoDAOInterface
{
    /**
     * @return Variacao[]
     */
    public function listarVariacoes(): array;

    public function buscarVariacaoPorId(int $id): ?Variacao;

    public function criarNovaVariacao(Variacao $variacao): int;

    /**
     * @param int $id
     * @param array{
     *   produtoId: int,
     *   tamanho: string,
     *   estoque: int,
     * } $dados
     */
    public function atualizarVariacao(int $id, array $dados): int;

    public function removerVariacaoPorId(int $id): int;

    public function buscarPrecoVariacao(int $id): float;
}

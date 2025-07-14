<?php

namespace Src\DAO;

use Src\Model\Endereco;

interface EnderecoDAOInterface
{
    /** @return Endereco[]|null */
    public function listarEnderecos(): array|null;

    public function buscarEnderecoPorId(int $id): Endereco|null;

    /**
     * @param array{
     *  clienteId: int,
     *  logradouro: string,
     *  cidade: string,
     *  bairro: string,
     *  numero: string,
     *  cep: string,
     *  complemento: string
     * } $dados
     */
    public function criarNovoEndereco(array $dados): int;

    public function atualizarEndereco(int $id, array $dados): int;

    public function removerEnderecoPorId(int $id): int;
}

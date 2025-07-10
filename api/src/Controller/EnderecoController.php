<?php

namespace Src\Controller;

use PDO;
use Src\Model\Endereco;
use Src\Service\EnderecoService;

class EnderecoController
{

    private EnderecoService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new EnderecoService($pdo);
    }

    /**
     * @return Endereco[] | null
     */
    public function listar(): array | null
    {
        return $this->service->listarEnderecos();
    }

    /**
     * @param int $id
     * @return Endereco | null
     */
    public function buscar(int $id): Endereco | null
    {
        return $this->service->buscarEnderecoPorId($id);
    }

    /**
     * @param array{
     * clienteId: int,
     * logradouro: string,
     * cidade: string,
     * bairro: string,
     * numero: string,
     * cep: string,
     * complemento: string
     * } $dados
     * @return int
     */
    public function criar(array $dados): int
    {
        return $this->service->criarNovoEndereco($dados);
    }

    /**
     * @param int $id
     * @param array{
     * logradouro: string,
     * cidade: string,
     * bairro: string,
     * numero: string,
     * cep: string,
     * complemento: string,
     * clienteId: int
     * } $dados
     * @return int
     */
    public function atualizar(int $id, array $dados): int
    {
        return $this->service->atualizarEndereco($id, $dados);
    }

    public function remover(int $id): int
    {
        return $this->service->removerEnderecoPorId($id);
    }
}

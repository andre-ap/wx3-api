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
     * @return Endereco[]
     */
    public function listar(): array
    {
        return $this->service->listarEnderecos(); 
    }

    /**
     * @param int $id
     * @return Endereco
     */
    public function buscar(int $id): Endereco
    {
        return $this->service->buscarEnderecoPorId($id);
    }

    /**
     * @param array{
     * 
     * } $dados
     * @return int
     */
    public function criar (array $dados): int
    {
        return $this->service->criarNovoEndereco($dados);
    }

    public function atualizar (int $id, array $dados): int
    {
        return $this->service->atualizarEndereco($id, $dados);
    }

    public function remover (int $id): int
    {
        return $this->service->removerEnderecoPorId($id);
    }
}
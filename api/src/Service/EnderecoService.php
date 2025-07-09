<?php

namespace Src\Service;

use PDO;
use Src\DAO\EnderecoDAO;
use Src\Model\Endereco;

class EnderecoService
{
    private EnderecoDAO $dao;

    public function __construct(PDO $pdo)
    {
        $this->dao = new EnderecoDAO($pdo);
    }

    /**
     * @return Endereco[]
     */
    public function listarEnderecos(): array
    {
        return $this->dao->listarEnderecos();
    }

    public function buscarEnderecoPorId(int $id): Endereco
    {
        return $this->dao->buscarEnderecoPorId($id);
    }

    /**
     * @param array{
     * 
     * } $dados
     * @return int
     */
    public function criarNovoEndereco (array $dados): int
    {
        return $this->dao->criarNovoEndereco($dados);
    }

    public function atualizarEndereco (int $id, array $dados): int
    {
        return $this->dao->atualizarEndereco($id, $dados);
    }

    public function removerEnderecoPorId (int $id): int
    {
        return $this->dao->removerEnderecoPorId($id);
    }
}

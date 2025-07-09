<?php

namespace Src\Service;

use PDO;
use Src\DAO\VariacaoDAO;
use Src\Model\Variacao;

class VariacaoService
{
    private VariacaoDAO $dao;

    public function __construct(PDO $pdo)
    {
        $this->dao = new VariacaoDAO($pdo);
    }

    public function listarVariacoes (): array
    {
        return $this->dao->listarVariacoes();
    }

    public function buscarVariacaoPorId ($id): Variacao
    {
        return $this->dao->buscarVariacaoPorId($id);
    }
 
    public function criarNovaVariacao (array $dados): int
    {
        return $this->dao->criarNovaVariacao($dados);
    }

    public function atualizarVariacao (int $id, array $dados): int
    {
        return $this->dao->atualizarVariacao($id, $dados);
    }
 
    public function removerVariacaoPorId (int $id): int
    {
        return $this->dao->removerVariacaoPorId($id);
    }
}

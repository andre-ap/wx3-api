<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Endereco;

class EnderecoDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Endereco[]
     */
    public function listarEnderecos(): array
    {
        $ps = $this->pdo->query("SELECT id, cliente_id, logradouro, cidade, bairro, numero, cep, complemento FROM enderecos");

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        $enderecos = [];

        foreach ($dados as $linha) {
            $enderecos[] = new Endereco($linha);
        }

        return $enderecos;
    }

    public function buscarEnderecoPorId(int $id): Endereco
    {
        $sql = "SELECT id, cliente_id, logradouro, cidade, bairro, numero, cep, complemento 
                FROM enderecos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        $endereco = $ps->fetch(PDO::FETCH_ASSOC);

        return $endereco = new Endereco($endereco);
    }

    /**
     * @param array{
     * 
     * } $dados
     * @return int
     */
    public function criarNovoEndereco(array $dados): int
    {
        $sql = "INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento) 
        VALUES (:cliente_id, :logradouro, :cidade, :bairro, :numero, :cep, :complemento)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':cliente_id' => $dados['cliente_id'],
            ':logradouro' => $dados['logradouro'],
            ':cidade'     => $dados['cidade'],
            ':bairro'     => $dados['bairro'],
            ':numero'     => $dados['numero'],
            ':cep'        => $dados['cep'],
            ':complemento' => $dados['complemento']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function atualizarEndereco(int $id, array $dados): int
    {
        $sql = "UPDATE enderecos SET cliente_id = :cliente_id, logradouro = :logradouro, 
            cidade = :cidade, bairro = :bairro, numero = :numero, cep = :cep, complemento = :complemento
            WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':cliente_id' => $dados['cliente_id'],
            ':logradouro' => $dados['logradouro'],
            ':cidade'     => $dados['cidade'],
            ':bairro'     => $dados['bairro'],
            ':numero'     => $dados['numero'],
            ':cep'        => $dados['cep'],
            ':complemento' => $dados['complemento'],
            ':id' => $id
        ]);

        return $id;
    }

    public function removerEnderecoPorId (int $id): int
    {
        $sql = "DELETE FROM enderecos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        return $id;
    }
}

<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Endereco;

class EnderecoDAO implements EnderecoDAOInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Endereco[] | null
     */
    public function listarEnderecos(): array | null
    {
        $ps = $this->pdo->query(query: "SELECT id, cliente_id, logradouro,
                                 cidade, bairro, numero, cep, complemento 
                                 FROM enderecos");

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        $enderecos = [];

        foreach ($dados as $linha) {
            $enderecos[] = new Endereco(
                id: $linha['id'],
                clienteId: $linha['cliente_id'],
                logradouro: $linha['logradouro'],
                cidade: $linha['cidade'],
                bairro: $linha['bairro'],
                numero: $linha['numero'],
                cep: $linha['cep'],
                complemento: $linha['complemento'],
            );
        }

        return $enderecos;
    }

    /**
     * @param int $id
     * @return Endereco|null
     */
    public function buscarEnderecoPorId(int $id): Endereco | null
    {
        $sql = "SELECT id, cliente_id, logradouro, cidade, bairro, numero, cep, complemento 
                FROM enderecos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        $endereco = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$endereco) {
            return null;
        }

        return $endereco = new Endereco(
            id: $endereco['id'],
            clienteId: $endereco['cliente_id'],
            logradouro: $endereco['logradouro'],
            cidade: $endereco['cidade'],
            bairro: $endereco['bairro'],
            numero: $endereco['numero'],
            cep: $endereco['cep'],
            complemento: $endereco['complemento'],
        );
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
    public function criarNovoEndereco(array $dados): int
    {
        $sql = "INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento) 
        VALUES (:cliente_id, :logradouro, :cidade, :bairro, :numero, :cep, :complemento)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':cliente_id' => $dados['clienteId'],
            ':logradouro' => $dados['logradouro'],
            ':cidade'     => $dados['cidade'],
            ':bairro'     => $dados['bairro'],
            ':numero'     => $dados['numero'],
            ':cep'        => $dados['cep'],
            ':complemento' => $dados['complemento']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
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
    public function atualizarEndereco(int $id, array $dados): int
    {
        $sql = "UPDATE enderecos SET cliente_id = :cliente_id, logradouro = :logradouro, 
            cidade = :cidade, bairro = :bairro, numero = :numero, cep = :cep, complemento = :complemento
            WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':cliente_id' => $dados['clienteId'],
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

    /**
     * @param int $id
     * @return int
     */
    public function removerEnderecoPorId(int $id): int
    {
        $sql = "DELETE FROM enderecos WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        return $id;
    }
}

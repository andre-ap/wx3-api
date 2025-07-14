<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Cliente;

class ClienteDAO implements ClienteDAOInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @return Cliente[]
     */
    public function listarClientes(): array
    {
        $ps = $this->pdo->query("SELECT id, nome_completo, cpf, data_nascimento
                FROM clientes");

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        $clientes = [];

        foreach ($dados as $linha) {
            $clientes[] = new Cliente(
                id: $linha['id'],
                nomeCompleto: $linha['nome_completo'],
                cpf: $linha['cpf'],
                dataNascimento: $linha['data_nascimento']
            );
        }

        return $clientes;
    }

    /**
     * @param int $id
     * @return Cliente | null
     */
    public function buscarClientePorID(int $id): Cliente | null
    {
        $sql = "SELECT id, nome_completo, cpf, data_nascimento
                FROM clientes WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([":id" => $id]);

        $dados = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Cliente(
            id: $dados['id'],
            nomeCompleto: $dados['nome_completo'],
            cpf: $dados['cpf'],
            dataNascimento: $dados['data_nascimento']
        );
    }

    /**
     * @param Cliente $cliente
     * @return int
     */
    public function criarNovoCliente(Cliente $cliente): int
    {
        $sql = "INSERT INTO clientes (nome_completo, cpf, data_nascimento) VALUES (:nome_completo, :cpf, :data_nascimento)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ":nome_completo" => $cliente->nomeCompleto,
            ":cpf" => $cliente->cpf,
            ":data_nascimento" => $cliente->dataNascimento
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array{
     * nomeCompleto: string,
     * cpf: string,
     * dataNascimento: string,
     * } $dados
     * @return int
     */
    public function atualizarCliente(int $id, array $dados): int
    {
        $sql = "UPDATE clientes SET nome_completo = :nome_completo, cpf = :cpf, data_nascimento = :data_nascimento 
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':nome_completo' => $dados['nomeCompleto'],
            ':cpf' => $dados['cpf'],
            'data_nascimento' => $dados['dataNascimento'],
            ':id' => $id
        ]);

        return $id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerCliente(int $id): int
    {
        $sql = "DELETE from clientes WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([":id" => $id]);

        return $id;
    }

    /**
     * @param string $cpf
     * @return bool
     */
    public function verificarCliente(string $cpf): bool
    {
        $sql = "SELECT nome_completo FROM clientes WHERE cpf = :cpf";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':cpf' => $cpf]);

        $dados = $ps->fetch();

        if (!$dados) {
            return false;
        }

        return true;
    }
}

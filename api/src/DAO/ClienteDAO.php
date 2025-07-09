<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Cliente;

class ClienteDAO
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
        $ps = $this->pdo->query ("SELECT id, nome_completo, cpf, data_nascimento
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
            $clientes[] = new Cliente($linha);
        }

        return $clientes;
    }

    /**
     * @param int $id
     * @return Cliente | array<void>
     */
    public function buscarClientePorID(int $id): Cliente | array
    {
        $sql = "SELECT id, nome_completo, cpf, data_nascimento
                FROM clientes WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([":id" => $id]);

        $dados = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        return new Cliente($dados);
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
            ":nome_completo" => $cliente->nome,
            ":cpf" => $cliente->cpf,
            ":data_nascimento" => $cliente->dataNascimento
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array{
     * nome: string,
     * cpf:string,
     * data_nascimento: string
     * } $dados
     * @return int
     */
    public function atualizarCliente(int $id, array $dados): int
    {
        $sql = "UPDATE clientes SET nome_completo = :nome_completo, cpf = :cpf, data_nascimento = :data_nascimento 
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':nome_completo' => $dados['nome_completo'],
            ':cpf' => $dados['cpf'],
            'data_nascimento' => $dados['data_nascimento'],
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
}

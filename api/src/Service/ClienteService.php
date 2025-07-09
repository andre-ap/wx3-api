<?php

namespace Src\Service;

use PDO;
use Src\DAO\ClienteDAO;
use Src\Exception\ClienteException;
use Src\Model\Cliente;

class ClienteService
{
    private ClienteDAO $dao;

    public function __construct(PDO $pdo)
    {
        $this->dao = new ClienteDAO($pdo);
    }

    /**
     * @return Cliente[]
     */
    public function listarClientes()
    {
        return $this->dao->listarClientes();
    }

    /**
     * @param int $id
     * @return Cliente | array<void>
     */
    public function buscarClientePorID(int $id): Cliente | array
    {
        $this->validarId($id);

        return $this->dao->buscarClientePorID($id);
    }


    /**
     * @param array{
     *   id: int | null,
     *   nome_completo: string,
     *   cpf: string,
     *   data_nascimento: string,
     * } $dados
     * @return int
     */
    public function criarNovoCliente($dados): int
    {
        $cliente = new Cliente($dados);

        return $this->dao->criarNovoCliente($cliente);
    }

    /**
     * @param int $id
     * @param array{
     *   id: int | null,
     *   nome: string,
     *   cpf: string,
     *   data_nascimento: string,
     * } $dados
     * @return int
     */
    public function atualizarCliente($id, $dados): int
    {
        $this->validarId($id);

        $this->validarDados($dados);

        return $this->dao->atualizarCliente($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerCliente($id): int
    {
        $this->validarId($id);

        return $this->dao->removerCliente($id);
    }

    /**
     * @param int $id
     * @return void
     */
    public function validarId(int $id): void
    {
        if ($id <= 0) {
            throw ClienteException::idInvalido();
        }
    }

    /**
     *@param array{
     * id: int | null,
     * nome_completo: string,
     * cpf: string,
     * data_nascimento: string,
     * } $dados
     * @return void
     */
    public function validarDados(array $dados): void
    {
        if (empty($dados['nome_completo']) || strlen($dados['nome_completo']) < 2) {
            throw ClienteException::nomeInvalido();
        }

        if (!isset($dados['cpf']) || !ctype_digit($dados['cpf']) || strlen($dados['cpf']) !== 11) {
            throw ClienteException::cpfInvalido();
        }

        // Validar Data
    }
}

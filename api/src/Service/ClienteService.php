<?php

namespace Src\Service;

use Src\DAO\ClienteDAOInterface;
use Src\Exception\ClienteException;
use Src\Model\Cliente;

class ClienteService
{
    private const TAMANHO_CPF = 11;

    private ClienteDAOInterface $dao;

    public function __construct(ClienteDAOInterface $dao)
    {
        $this->dao = $dao;
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
     * @return Cliente | null
     */
    public function buscarClientePorID(int $id): Cliente | null
    {
        $this->validarId($id);

        return $this->dao->buscarClientePorID($id);
    }


    /**
     * @param array{
     * nomeCompleto: string,
     * cpf: string,
     * dataNascimento: string
     * } $dados
     * @return int
     */
    public function criarNovoCliente($dados): int
    {
        $this->validarDados($dados);

        if ($this->dao->verificarCliente($dados['cpf'])) {
            throw ClienteException::clienteExistente();
        }

        $cliente = new Cliente(
            nomeCompleto: $dados['nomeCompleto'],
            cpf: $dados['cpf'],
            dataNascimento: $dados['dataNascimento']
        );

        return $this->dao->criarNovoCliente($cliente);
    }

    /**
     * @param int $id
     * @param array{
     *  nomeCompleto: string, 
     *  cpf: string,
     *  dataNascimento: string
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

        if (!$this->dao->buscarClientePorId($id)) {
            throw ClienteException::clienteInexistente();
        }
    }

    /**
     * @param array{
     * nomeCompleto: string,
     * cpf: string,
     * dataNascimento: string
     * } $dados
     * @throws ClienteException
     * @return void
     */
    public function validarDados(array $dados): void
    {
        if (empty($dados['nomeCompleto']) || strlen($dados['nomeCompleto']) < 2) {
            throw ClienteException::nomeInvalido();
        }

        if (!self::validarCPF($dados['cpf'])) {
            throw ClienteException::cpfInvalido();
        }
    }


    // https://www.goulart.pro.br/cbasico/Calculo_dv.htm
    public function validarCPF(string $cpf)
    {
        $soma = 0;
        $primeiroDigito = 0;
        $segundoDigito = 0;

        $cpf = preg_replace("/\D/", "", $cpf);

        if (strlen($cpf) != self::TAMANHO_CPF) {
            throw ClienteException::cpfInvalido();
        }


        for ($i = 0; $i < 9; $i++) {
            $soma += (int) $cpf[$i] * (10 - $i);
        }

        $primeiroDigito = $soma % 11;

        if ($primeiroDigito < 2) {
            $primeiroDigito = 0;
        } else {
            $primeiroDigito = 11 - $primeiroDigito;
        }

        $soma = 0;

        for ($i = 0; $i < 10; $i++) {
            $soma += (int) $cpf[$i] * (11 - $i);
        }

        $segundoDigito = $soma % 11;

        if ($segundoDigito < 2) {
            $segundoDigito = 0;
        } else {
            $segundoDigito = 11 - $segundoDigito;
        }

        if ($cpf[9] == $primeiroDigito && $cpf[10] == $segundoDigito) {
            return true;
        } else {
            return false;
        }
    }
}

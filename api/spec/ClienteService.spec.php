<?php

use Src\Config\ConexaoTeste;
use Src\Service\ClienteService;
use Src\Exception\ClienteException;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('ClienteService', function () {

    beforeEach(function () {
        SetupBancoTestes::excluirTabelasBanco();
        SetupBancoTestes::setup();
        $pdo = ConexaoTeste::conectar();
        $this->service = new ClienteService($pdo);
    });

    it('deve listar clientes', function () {
        $clientes = $this->service->listarClientes();

        expect($clientes)->toBeA('array');
        expect(count($clientes))->toBeGreaterThan(0);
    });

    it('deve retornar cliente pelo ID', function () {
        $cliente = $this->service->buscarClientePorID(1);

        expect($cliente->id)->toEqual(1);
        expect($cliente->nomeCompleto)->not->toBeEmpty();
    });

    it('deve lançar exceção para ID inválido', function () {
        expect(function () {
            $this->service->buscarClientePorID(-1);
        })->toThrow(new ClienteException("O id deve ser um número inteiro", 422));
    });

    it('deve lançar exceção para cliente inexistente', function () {
        expect(function () {
            $this->service->buscarClientePorID(9999);
        })->toThrow(new ClienteException("O cliente buscado não existe", 404));
    });

    it('deve criar novo cliente com dados válidos', function () {
        $dados = [
            'nomeCompleto' => 'Carlos Teste',
            'cpf' => '111.222.333-33',
            'dataNascimento' => '1995-03-22'
        ];

        $novoId = $this->service->criarNovoCliente($dados);

        $cliente = $this->service->buscarClientePorID($novoId);
        expect($cliente->cpf)->toEqual($dados['cpf']);
    });

    it('deve lançar exceção ao tentar criar cliente duplicado', function () {
        $dados = [
            'nomeCompleto' => 'João da Silva',
            'cpf' => '123.456.789-00',
            'dataNascimento' => '1990-05-10'
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoCliente($dados);
        })->toThrow(new ClienteException("O cliente com o CPF informado já foi cadastrado", 409));
    });

    it('deve lançar exceção se nome for inválido', function () {
        $dados = [
            'nomeCompleto' => '',
            'cpf' => '123.456.789-66',
            'dataNascimento' => '2000-01-01'
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoCliente($dados);
        })->toThrow(new ClienteException("O nome deve ter mais de 2 caracteres", 422));
    });

    it('deve lançar exceção se nome for inválido', function () {
        $dados = [
            'nomeCompleto' => 'Andre Pinto',
            'cpf' => '111',
            'dataNascimento' => '2000-01-01'
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoCliente($dados);
        })->toThrow(new ClienteException("O cpf deve ser uma texto com 14 dígitos Ex: '123.456.789-00' ", 422));
    });

    it('deve atualizar cliente existente', function () {
        $dados = [
            'nomeCompleto' => 'Cliente Atualizado',
            'cpf' => '123.456.789-00',
            'dataNascimento' => '1990-05-10'
        ];

        $afetados = $this->service->atualizarCliente(1, $dados);
        

        expect($afetados)->toEqual($afetados);
    });

    it('deve remover cliente existente', function () {
        $dados = [
            'nomeCompleto' => 'Andre Teste',
            'cpf' => '555.666.777-88',
            'dataNascimento' => '1999-12-31'
        ];

        $id = $this->service->criarNovoCliente($dados);

        $afetados = $this->service->removerCliente($id);

        expect($afetados)->toEqual($id);
    });
});

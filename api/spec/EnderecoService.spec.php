<?php

use Src\Config\ConexaoDB;
use Src\DAO\EnderecoDAO;
use Src\Service\EnderecoService;
use Src\Exception\EnderecoException;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('EnderecoService', function () {

    beforeEach(function () {
        SetupBancoTestes::excluirTabelasBanco();
        SetupBancoTestes::setup();
        $pdo = ConexaoDB::conectar();
        $dao = new EnderecoDAO($pdo);

        $this->service = new EnderecoService($dao);
    });

    it('deve listar endereços', function () {
        $enderecos = $this->service->listarEnderecos();

        expect($enderecos)->toBeA('array');
        expect(count($enderecos))->toBeGreaterThan(0);
    });

    it('deve buscar endereço por ID', function () {
        $endereco = $this->service->buscarEnderecoPorId(1);

        expect($endereco->id)->toEqual(1);
        expect($endereco->cidade)->not->toBeEmpty();
    });

    it('deve lançar exceção para ID inválido', function () {
        expect(function () {
            $this->service->buscarEnderecoPorId(-5);
        })->toThrow(new EnderecoException("ID do endereço inválido.", 422));
    });

    it('deve lançar exceção para endereço inexistente', function () {
        expect(function () {
            $this->service->buscarEnderecoPorId(9999);
        })->toThrow(new EnderecoException("Endereço não encontrado.", 404));
    });

    it('deve criar um novo endereço com dados válidos', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua Teste',
            'cidade' => 'Cantagalo',
            'bairro' => 'Centro',
            'numero' => '123',
            'cep' => '28500-000',
            'complemento' => 'Primeira casa'
        ];

        $novoId = $this->service->criarNovoEndereco($dados);

        expect($novoId)->toBeGreaterThan(0);
        $endereco = $this->service->buscarEnderecoPorId($novoId);
        expect($endereco->logradouro)->toEqual('Rua Teste');
    });

    it('deve lançar exceção se id for invalido', function () {
        $dados = [
            'clienteId' => 0,
            'logradouro' => '',
            'cidade' => '',
            'bairro' => '',
            'numero' => '',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::clienteIdInvalido());
    });

    it('deve lançar exceção se logradouro for inválido', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => '',
            'cidade' => '',
            'bairro' => '',
            'numero' => '',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::logradouroInvalido());
    });

    it('deve lançar exceção se cidade for inválida', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua tal',
            'cidade' => '',
            'bairro' => '',
            'numero' => '',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::cidadeInvalida());
    });

    it('deve lançar exceção se bairro for inválido', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua tal',
            'cidade' => 'Cantagalo',
            'bairro' => '',
            'numero' => '',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::bairroInvalido());
    });

    it('deve lançar exceção se o número for inválido', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua tal',
            'cidade' => 'Cantagalo',
            'bairro' => 'Centro',
            'numero' => '',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::numeroInvalido());
    });

    it('deve lançar exceção se o cep for inválido', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua tal',
            'cidade' => 'Cantagalo',
            'bairro' => 'Centro',
            'numero' => '14',
            'cep' => '',
            'complemento' => ''
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoEndereco($dados);
        })->toThrow(EnderecoException::cepInvalido());
    });

    it('deve atualizar um endereço existente', function () {
        $dadosAtualizados = [
            'clienteId' => 1,
            'logradouro' => 'Rua Atualizada',
            'cidade' => 'Nova Cidade',
            'bairro' => 'Novo Bairro',
            'numero' => '456',
            'cep' => '12345-678',
            'complemento' => 'Casa 2'
        ];

        $afetados = $this->service->atualizarEndereco(1, $dadosAtualizados);

        expect($afetados)->toEqual(1);
        $endereco = $this->service->buscarEnderecoPorId(1);
        expect($endereco->logradouro)->toEqual('Rua Atualizada');
    });

    it('deve remover um endereço existente', function () {
        $dados = [
            'clienteId' => 1,
            'logradouro' => 'Rua teste',
            'cidade' => 'cantagalo',
            'bairro' => 'Centro',
            'numero' => '123',
            'cep' => '00000-000',
            'complemento' => ''
        ];

        $id = $this->service->criarNovoEndereco($dados);

        $afetados = $this->service->removerEnderecoPorId($id);
        expect($afetados)->toEqual($id);
    });
});

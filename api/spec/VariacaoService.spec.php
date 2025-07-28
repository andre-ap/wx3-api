<?php

use Src\Config\ConexaoDB;
use Src\DAO\VariacaoDAO;
use Src\Service\VariacaoService;
use Src\Exception\VariacaoException;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('VariacaoService', function () {

    beforeEach(function () {
        SetupBancoTestes::excluirTabelasBanco();
        SetupBancoTestes::setup();
        $pdo = ConexaoDB::conectar();
        $dao = new VariacaoDAO($pdo);
        $this->service = new VariacaoService($dao);
    });

    it('deve listar variações', function () {
        $variacoes = $this->service->listarVariacoes();

        expect($variacoes)->toBeA('array');
        expect(count($variacoes))->toBeGreaterThan(0);
    });

    it('deve buscar variação por ID', function () {
        $variacao = $this->service->buscarVariacaoPorId(1);

        expect($variacao)->toBeAnInstanceOf(\Src\Model\Variacao::class);
        expect($variacao->id)->toEqual(1);
    });

    it('deve lançar exceção se ID for inválido', function () {
        expect(function () {
            $this->service->buscarVariacaoPorId(0);
        })->toThrow(new VariacaoException("ID da variação inválido", 422));
    });

    it('deve criar nova variação com dados válidos', function () {
        $dados = [
            'produtoId' => 1,
            'tamanho' => 'G',
            'estoque' => 20,
        ];

        $id = $this->service->criarNovaVariacao($dados);

        expect($id)->toBeGreaterThan(0);
    });

    it('deve lançar exceção com produtoId inválido', function () {
        $dados = [
            'produtoId' => 0,
            'tamanho' => 'M',
            'estoque' => 5,
        ];

        expect(function () use ($dados) {
            $this->service->criarNovaVariacao($dados);
        })->toThrow(new VariacaoException("ID do produto inválido", 422));
    });

    it('deve atualizar variação existente', function () {
        $dados = [
            'produtoId' => 1,
            'tamanho' => 'GG',
            'estoque' => 100,
        ];

        $afetados = $this->service->atualizarVariacao(1, $dados);

        expect($afetados)->toEqual(1);
    });

    it('deve lançar exceção ao atualizar ID inválido', function () {
        $dados = [
            'produtoId' => 1,
            'tamanho' => 'P',
            'estoque' => 5,
        ];

        expect(function () use ($dados) {
            $this->service->atualizarVariacao(0, $dados);
        })->toThrow(new VariacaoException("ID da variação inválido", 422));
    });

    it('deve remover variação existente', function () {

        $dados = [
            'produtoId' => 1,
            'tamanho' => 'XG',
            'estoque' => 2,
        ];

        $novoID = $this->service->criarNovaVariacao($dados);

        $deletado = $this->service->removerVariacaoPorId($novoID);

        expect($novoID)->toEqual($deletado);
    });
});

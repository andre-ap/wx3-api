<?php

use Src\Config\ConexaoDB;
use Src\DAO\CategoriaDAO;
use Src\DAO\ProdutoDAO;
use Src\Exception\CategoriaException;
use Src\Service\ProdutoService;
use Src\Exception\ProdutoException;
use Src\Model\Produto;
use Src\Service\CategoriaService;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('ProdutoService', function () {

    beforeEach(function () {
        SetupBancoTestes::excluirTabelasBanco();
        SetupBancoTestes::setup();

        $pdo = ConexaoDB::conectar();

        $produtoDAO = new ProdutoDAO($pdo);
        $categoriaDAO = new CategoriaDAO($pdo);
        $categoriaService = new CategoriaService($categoriaDAO);

        $this->service = new ProdutoService($produtoDAO, $categoriaService);
    });

    it('deve listar todos os produtos', function () {
        $produtos = $this->service->listarTodosProdutos();

        expect($produtos)->toBeA('array');
        expect(count($produtos))->toBeGreaterThan(0);
    });

    it('deve retornar um produto', function () {
        $produto = $this->service->buscarProdutoPorId(1);

        expect($produto)->toBeAnInstanceOf(Produto::class);
        expect($produto->id)->toEqual(1);
    });

    it('deve lançar exceção para ID negativo', function () {
        expect(function () {
            $this->service->buscarProdutoPorId(-1);
        })->toThrow(new ProdutoException("O id deve ser um número inteiro.", 422));
    });

    it('deve lançar exceção para ID string', function () {
        expect(function () {
            $this->service->buscarProdutoPorId('a');
        })->toThrow(new TypeError());
    });

    it('deve lançar exceção para produto inexistente', function () {
        expect(function () {
            $this->service->buscarProdutoPorId(999);
        })->toThrow(new ProdutoException("Produto com ID 999 não encontrado", 404));
    });

    it('deve criar novo produto com dados válidos', function () {
        $dados = [
            'id' => 0,
            'nome' => 'camiseta',
            'cor' => 'branca',
            'imagem' => 'camiseta.png',
            'preco' => 99.90,
            'descricao' => 'descricao camisa',
            'peso' => 0.5,
            'categoriaId' => 1
        ];

        $novoId = $this->service->criarNovoProduto($dados);

        expect($novoId)->toBeGreaterThan(0);
    });

    it('deve lançar exceção ao criar produto com categoria inexistente', function () {
        $dados = [
            'id' => 0,
            'nome' => 'produto teste',
            'cor' => 'preto',
            'imagem' => 'produto.png',
            'preco' => 50.00,
            'descricao' => 'descrição teste',
            'peso' => 0.3,
            'categoriaId' => 999
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoProduto($dados);
        })->toThrow(new CategoriaException("A categoria de id 999 não foi encontrada", 404));
    });

    it('deve atualizar produto existente com dados válidos', function () {
        $dados = [
            'nome' => 'produto atualizado',
            'cor' => 'Vermelho',
            'imagem' => 'novo.png',
            'preco' => 150.00,
            'descricao' => 'descricao teste',
            'peso' => 1.2,
            'categoriaId' => 1
        ];

        $linhas = $this->service->atualizarProduto(1, $dados);

        expect($linhas)->toEqual(1);
    });

    it('deve lançar exceção ao atualizar produto inexistente', function () {
        $dados = [
            'nome' => 'produto teste',
            'cor' => 'azul',
            'imagem' => 'produto.png',
            'preco' => 80.00,
            'descricao' => 'descricao teste',
            'peso' => 0.12,
            'categoriaId' => 1
        ];

        expect(function () use ($dados) {
            $this->service->atualizarProduto(11111, $dados);
        })->toThrow(new ProdutoException("Produto com ID 11111 não encontrado", 404));
    });

    it('deve remover produto existente', function () {
        $dados = [
            'id' => 0,
            'nome' => 'camisa',
            'cor' => 'azul',
            'imagem' => 'camisa.png',
            'preco' => 99.90,
            'descricao' => 'camisa',
            'peso' => 0.5,
            'categoriaId' => 1
        ];

        $novoId = $this->service->criarNovoProduto($dados);

        $id = $this->service->removerProduto($novoId);

        expect($id)->toEqual($novoId);
    });

    it('deve lançar exceção ao remover produto inexistente', function () {
        expect(function () {
            $this->service->removerProduto(11111);
        })->toThrow(new ProdutoException("Produto com ID 11111 não encontrado", 404));
    });
});

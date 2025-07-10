<?php

use Src\Config\ConexaoTeste;
use Src\Service\CategoriaService;
use Src\Exception\CategoriaException;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('CategoriaService', function () {

    beforeAll(function () {
        SetupBancoTestes::setup();
    });

    beforeEach(function () {
        $pdo = ConexaoTeste::conectar();
        $this->service = new CategoriaService($pdo);
    });

    it('deve listar as categorias corretamente', function () {
        $categorias = $this->service->listarTodasCategorias();

        expect($categorias)->toBeA('array');
        expect(count($categorias))->toBeGreaterThan(0);
        expect($categorias[0]->nome)->not->toBeEmpty();
    });

    it('deve retornar categoria pelo ID', function () {
        $categoria = $this->service->buscarCategoriaPorId(1);

        expect($categoria->id)->toEqual(1);
        expect($categoria->nome)->not->toBeEmpty();
    });

    it('deve lançar exceção se categoria não existir', function () {
        expect(function () {
            $this->service->buscarCategoriaPorId(9999);
        })->toThrow(new CategoriaException("A categoria de id 9999 não foi encontrada", 404));
    });

    it('deve lançar exceção para categoria inválida', function () {
        expect(function () {
            $this->service->buscarCategoriaPorId("abc");
        })->toThrow(new TypeError());
    });

    it('deve lançar exceção para chamada sem argumento nenhum', function () {
        expect(function () {
            $this->service->buscarCategoriaPorId();
        })->toThrow(new ArgumentCountError());
    });

    it('deve lançar exceção para chamada sem argumento com tipo negativo', function () {
        expect(function () {
            $this->service->buscarCategoriaPorId(-1);
        })->toThrow(new CategoriaException("O id deve ser um número inteiro", 422));
    });

    it('deve criar uma nova categoria com sucesso', function () {
        $dados = [
            'nome' => 'Chapeus',
            'descricao' => 'Pra colocar na cabeça =D'
        ];

        $id = $this->service->criarNovaCategoria($dados);
        expect($id)->toBeGreaterThan(0);
    });

    it('deve falhar ao tentar ciar uma categoria com nome invalido', function () {
        $dados = [
            'nome' => 1,
            'descricao' => 'Pra colocar na cabeça =D'
        ];

        expect(function () use ($dados) {
            $this->service->criarNovaCategoria($dados);
        })->toThrow(new CategoriaException("O nome da categoria deve ter pelo menos 2 caracteres", 422));
    });

    it('deve falhar ao tentar ciar uma categoria com descricacao invalida', function () {
        $dados = [
            'nome' => "Chapeus",
            'descricao' => 'test'
        ];

        expect(function () use ($dados) {
            $this->service->criarNovaCategoria($dados);
        })->toThrow(new CategoriaException("A descrição da categoria deve ter pelo menos 5 caracteres", 422));
    });

    it('deve atualizar uma categoria existente', function () {
        $dados = [
            'id' => 1,
            'nome' => 'Atualizada',
            'descricao' => 'Categoria atualizada'
        ];

        $linhasAfetadas = $this->service->atualizarCategoria(1, $dados);
        expect($linhasAfetadas)->toEqual(1);
    });

    it('deve lançar exceção ao atualizar categoria inexistente', function () {
        $dados = [
            'id' => 999,
            'nome' => 'Qualquer',
            'descricao' => 'Inexistente'
        ];

        expect(function () use ($dados) {
            $this->service->atualizarCategoria(999, $dados);
        })->toThrow(CategoriaException::categoriaInexistente());
    });

    it('deve remover uma categoria existente', function () {

        $dados = [
            'nome' => 'Categoria Temporária',
            'descricao' => 'Categoria usada para teste de remoção'
        ];

        $id = $this->service->criarNovaCategoria($dados);

        $linhasAfetadas = $this->service->removerItemPorID($id);

        expect($linhasAfetadas)->toEqual($id);
    });


});

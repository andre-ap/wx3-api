<?php

use Src\Config\ConexaoDB;
use Src\Config\ConexaoTeste;
use Src\DAO\ClienteDAO;
use Src\DAO\EnderecoDAO;
use Src\DAO\PedidoDAO;
use Src\DAO\VariacaoDAO;
use Src\Enum\FormaPagamento;
use Src\Exception\ClienteException;
use Src\Exception\EnderecoException;
use Src\Service\PedidoService;
use Src\Exception\PedidoException;
use Src\Service\ClienteService;
use Src\Service\EnderecoService;
use Src\Service\VariacaoService;

require_once __DIR__ . '/SetupBancoTestes.php';

describe('PedidoService', function () {

    beforeEach(function () {
        SetupBancoTestes::excluirTabelasBanco();
        SetupBancoTestes::setup();

        $pdo = ConexaoTeste::conectar();


        $pedidoDAO = new PedidoDAO($pdo);
        $clienteDAO = new ClienteDAO($pdo);
        $enderecoDAO = new EnderecoDAO($pdo);
        $variacaoDAO = new VariacaoDAO($pdo);

        $clienteService = new ClienteService($clienteDAO);
        $enderecoService = new EnderecoService($enderecoDAO);
        $variacaoService = new VariacaoService($variacaoDAO);

        $this->service = new PedidoService(
            $pedidoDAO,
            $clienteService,
            $enderecoService,
            $variacaoService
        );
    });

    it('deve criar um novo pedido', function () {
        $dados = [
            'clienteId' => 1,
            'enderecoEntregaId' => 1,
            'formaPagamento' => 'PIX',
            'itens' => [
                [
                    'variacaoId' => 1,
                    'quantidade' => 2
                ]
            ]
        ];

        $idPedido = $this->service->criarNovoPedido($dados);

        expect($idPedido)->toBeGreaterThan(0);
    });

    it('deve lançar exceção para cliente inexistente', function () {
        $dados = [
            'clienteId' => 99999,
            'enderecoEntregaId' => 1,
            'formaPagamento' => 'PIX',
            'itens' => [
                ['variacaoId' => 1, 'quantidade' => 1]
            ]
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoPedido($dados);
        })->toThrow(new ClienteException("O cliente buscado não existe", 404));
    });

    it('deve lançar exceção para endereço inexistente', function () {
        $dados = [
            'clienteId' => 1,
            'enderecoEntregaId' => 999,
            'formaPagamento' => 'PIX',
            'itens' => [
                ['variacaoId' => 1, 'quantidade' => 1]
            ]
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoPedido($dados);
        })->toThrow(new EnderecoException("Endereço não encontrado.", 404));
    });

    it('deve lançar exceção para forma de pagamento inválida', function () {
        $dados = [
            'clienteId' => 1,
            'enderecoEntregaId' => 1,
            'formaPagamento' => 'DINHEIRO',
            'itens' => [
                ['variacaoId' => 1, 'quantidade' => 1]
            ]
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoPedido($dados);
        })->toThrow(new PedidoException("Forma de pagamento inválida.", 422));
    });

    it('deve lançar exceção para item com quantidade inválida', function () {
        $dados = [
            'clienteId' => 1,
            'enderecoEntregaId' => 1,
            'formaPagamento' => 'PIX',
            'itens' => [
                ['variacaoId' => 1, 'quantidade' => 0]
            ]
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoPedido($dados);
        })->toThrow(new PedidoException("O id das variações precisam ser números maiores que 0", 422));
    });

    it('deve lançar exceção para variação com estoque insuficiente', function () {
        $dados = [
            'clienteId' => 1,
            'enderecoEntregaId' => 1,
            'formaPagamento' => 'PIX',
            'itens' => [
                ['variacaoId' => 1, 'quantidade' => 999]
            ]
        ];

        expect(function () use ($dados) {
            $this->service->criarNovoPedido($dados);
        })->toThrow(new PedidoException("Quantidade insuficiente de itens no estoque.", 422));
    });

    it('deve calcular total corretamente com pagamento via PIX', function () {
        $itens = [
            ['variacaoId' => 1, 'quantidade' => 2]
        ];

        $total = $this->service->calcularTotal($itens, FormaPagamento::PIX);

        expect($total)->toBeAn('array');
        expect($total['frete'])->toEqual(10.00);
        expect($total['desconto'])->toBeCloseTo(12.98,2 );
        expect($total['valorTotal'])->toBeCloseTo(116.82, 2);
    });
});

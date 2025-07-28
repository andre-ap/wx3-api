<?php

namespace Src\Service;

use Src\DAO\PedidoDAOInterface;
use Src\Exception\PedidoException;
use Src\Model\ItemPedido;
use Src\Model\Pedido;
use Src\Model\Variacao;

class PedidoService
{
    private const FRETE_PADRAO = 10.00;

    private PedidoDAOInterface $dao;
    private ClienteService $clienteService;
    private EnderecoService $enderecoService;
    private VariacaoService $variacaoService;

    public function __construct(
        PedidoDAOInterface $pedidoDAO,
        ClienteService $clienteService,
        EnderecoService $enderecoService,
        VariacaoService $variacaoService
    ) {
        $this->dao = $pedidoDAO;
        $this->clienteService = $clienteService;
        $this->enderecoService = $enderecoService;
        $this->variacaoService = $variacaoService;
    }

    /**
     * @param array{
     * clienteId: int,
     * enderecoEntregaId: int,
     * formaPagamento: 'PIX'|'BOLETO'|'CARTAO_1X',
     * itens: array<array{
     *  variacaoId: int,
     *  quantidade: int
     * }>
     * } $dados
     * @return int
     */
    public function criarNovoPedido(array $dados): int
    {
        $this->validarDados($dados);

        $formaPagamento = $dados['formaPagamento'];
        $itens = $dados['itens'];

        $total = $this->calcularTotal($itens, $formaPagamento);

        $pedido = new Pedido(
            clienteId: $dados['clienteId'],
            enderecoEntregaId: $dados['enderecoEntregaId'],
            formaPagamento: $dados['formaPagamento'],
            valorFrete: (float) $total['frete'],
            desconto: (float) $total['desconto'],
            valorTotal: (float) $total['valorTotal'],
            dataPedido: date('Y-m-d')
        );

        $itensPedido = [];

        foreach ($itens as $item) {
            $variacao = $this->variacaoService->buscarVariacaoPorId($item['variacaoId']);
            
            if (!$variacao instanceof Variacao) {
                throw PedidoException::variacaoInexistente();
            }

            $preco = $this->variacaoService->buscarPreco($item['variacaoId']);

            $itensPedido[] = new ItemPedido([
                'variacaoId' => $item['variacaoId'],
                'quantidade' => $item['quantidade'],
                'precoUnitario' => $preco
            ]);
        }

        return $this->dao->criarNovoPedido($pedido, $itensPedido);
    }

    /**
     * @param array{
     *   clienteId: int,
     *   enderecoEntregaId: int,
     *   formaPagamento: string,
     *   itens: array<array{
     *     variacaoId: int,
     *     quantidade: int
     *   }>
     * } $dados
     * @return void
     */
    private function validarDados(array $dados): void
    {
        if ($dados['clienteId'] <= 0) {
            throw PedidoException::clienteInvalido();
        }

        if (!$this->clienteService->buscarClientePorID($dados['clienteId'])) {
            throw PedidoException::clienteInexistente();
        }

        if ($dados['enderecoEntregaId'] <= 0) {
            throw PedidoException::enderecoInvalido();
        }

        if (!$this->enderecoService->buscarEnderecoPorId($dados['enderecoEntregaId'])) {
            throw PedidoException::enderecoInexistente();
        }

        $pagamentos = ['PIX', 'BOLETO', 'CARTAO_1X'];
        if (!in_array($dados['formaPagamento'], $pagamentos, true)) {
            throw PedidoException::formaPagamentoInvalida();
        }

        if (empty($dados['itens'])) {
            throw PedidoException::itensInvalidos();
        }

        foreach ($dados['itens'] as $item) {
            if ($item['variacaoId'] <= 0) {
                throw PedidoException::variacaoInvalida();
            }

            $variacao = $this->variacaoService->buscarVariacaoPorId($item['variacaoId']);
            if (!$variacao) {
                throw PedidoException::variacaoInexistente();
            }

            if ($item['quantidade'] <= 0) {
                throw PedidoException::variacaoInvalida();
            }

            if ($variacao->estoque < $item['quantidade']) {
                throw PedidoException::variacaoInsuficiente();
            }
        }
    }

    /**
     * @param array<array{
     *  variacaoId: int, 
     *  quantidade: int
     * }> $itens
     * @param 'PIX'|'BOLETO'|'CARTAO_1X' $formaPagamento
     * @return array{
     *  frete: float,
     *  desconto: float,
     *  valorTotal: float
     * }
     */
    public function calcularTotal($itens, $formaPagamento): array
    {
        $subtotal = 0.0;

        foreach ($itens as $item) {
            $variacao = $this->variacaoService->buscarVariacaoPorId((int)$item['variacaoId']);

            if (!$variacao) {
                throw PedidoException::variacaoInexistente();
            }

            $preco = $this->variacaoService->buscarPreco((int)$item['variacaoId']);
            $quantidade = (int)$item['quantidade'];
            $subtotal += $preco * $quantidade;
        }

        $frete = self::FRETE_PADRAO;
        $desconto = 0;

        if ($formaPagamento === 'PIX') {
            $desconto = ($subtotal + $frete) * 0.1;
        }

        $valorTotal = ($subtotal + $frete) - $desconto;

        return [
            'frete' => $frete,
            'desconto' => $desconto,
            'valorTotal' => $valorTotal
        ];
    }
}

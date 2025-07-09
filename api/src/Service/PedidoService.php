<?php

namespace Src\Service;

use PDO;
use Src\DAO\PedidoDAO;
use Src\Exception\PedidoException;
use Src\Model\ItemPedido;
use Src\Model\Pedido;

class PedidoService
{
    private const FRETE_PADRAO = 10.00;

    private PedidoDAO $dao;
    private ClienteService $clienteService;
    private EnderecoService $enderecoService;
    private VariacaoService $variacaoService;

    public function __construct(PDO $pdo)
    {
        $this->dao = new PedidoDAO($pdo);
        $this->clienteService = new ClienteService($pdo);
        $this->enderecoService = new EnderecoService($pdo);
        $this->variacaoService = new VariacaoService($pdo);
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
            dataPedido: date('Y-m-d H:i:s')
        );

        $pedidos = [];

        foreach ($itens as $item) {
            $variacao = $this->variacaoService->buscarVariacaoPorId($item['variacaoId']);

            $itensPedido[] = new ItemPedido([
                'variacaoId' => $item['variacaoId'],
                'quantidade' => $item['quantidade'],
                'precoUnitario' => $variacao->preco
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
     * @return int
     */
    private function validarDados(array $dados): void
    {
        if (!isset($dados['clienteId']) || !is_numeric($dados['clienteId'])) {
            throw PedidoException::clienteInvalido();
        }

        if (!$this->clienteService->buscarClientePorID($dados['clienteId'])) {
            throw PedidoException::clienteInexistente();
        }

        if (!isset($dados['enderecoEntregaId']) || !is_numeric($dados['enderecoEntregaId'])) {
            throw PedidoException::enderecoInvalido();
        }

        if (!$this->enderecoService->buscarEnderecoPorId($dados['enderecoEntregaId'])) {
            throw PedidoException::enderecoInexistente();
        }

        $pagamentos = ['PIX', 'BOLETO', 'CARTAO_1X'];
        if (empty($dados['formaPagamento']) || !in_array($dados['formaPagamento'], $pagamentos, true)) {
            throw PedidoException::formaPagamentoInvalida();
        }

        if (!isset($dados['itens']) || !is_array($dados['itens']) || empty($dados['itens'])) {
            throw PedidoException::itensInvalidos();
        }

        foreach ($dados['itens'] as $item) {
            if (!isset($item['variacaoId']) || !is_numeric($item['variacaoId'])) {
                throw PedidoException::variacaoInvalida();
            }

            $variacao = $this->variacaoService->buscarVariacaoPorId($item['variacaoId']);
            if (!$variacao) {
                throw PedidoException::variacaoInexistente();
            }

            if (!isset($item['quantidade']) || !is_numeric($item['quantidade'])) {
                throw PedidoException::variacaoInvalida();
            }

            if ($variacao->estoque < $item['quantidade']) {
                throw PedidoException::variacaoInsuficiente();
            }
        }
    }

    public function calcularTotal($itens, $formaPagamento): array
    {
        $subtotal = 0.0;

        foreach ($itens as $item) {
            $variacao = $this->variacaoService->buscarVariacaoPorId((int)$item['variacaoId']);
            $preco = $variacao->preco;
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

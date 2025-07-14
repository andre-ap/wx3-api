<?php

namespace Src\Controller;

use PDO;
use Src\Service\PedidoService;

class PedidoController
{
    private PedidoService $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
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
    public function criar($dados): int
    {
        return $this->service->criarNovoPedido($dados);
    }
}

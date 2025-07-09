<?php

namespace Src\Controller;

use PDO;
use Src\Service\PedidoService;

class PedidoController
{
    private PedidoService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new PedidoService($pdo);
    }

    /**
     * @param array{
     *   clienteId: int,
     *   enderecoEntrega_id: int,
     *   formaPagamento: string,
     *   itens: array<array{
     *     variacaoId: int,
     *     quantidade: int
     *   }>
     * } $dados
     * @return int
    */
    public function criar($dados): int
    {
        return $this->service->criarNovoPedido($dados);
    }
}

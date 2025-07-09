<?php

namespace Src\Model;

class Pedido
{
    public function __construct(
        public int $clienteId,
        public int $enderecoEntregaId,
        public string $formaPagamento,
        public float $valorFrete,
        public float $desconto,
        public float $valorTotal,
        public string $dataPedido
    ) {}
}
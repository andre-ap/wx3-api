<?php

namespace Src\DAO;

use Src\Model\Pedido;
use Src\Model\ItemPedido;

interface PedidoDAOInterface
{
    /**
     * @param Pedido $pedido
     * @param ItemPedido[] $itens
     * @return int
     */
    public function criarNovoPedido(Pedido $pedido, array $itens): int;
}

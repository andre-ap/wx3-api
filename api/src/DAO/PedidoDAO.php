<?php

namespace Src\DAO;

use Exception;
use PDO;
use Src\Model\Pedido;
use Src\Model\ItemPedido;

class PedidoDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param Pedido $pedido
     * @param ItemPedido[] $itens
     * @return int
     */
    public function criarNovoPedido(Pedido $pedido, array $itens): int
    {
        try {
            $this->pdo->beginTransaction();

            $sqlPedido = "INSERT INTO pedidos 
                    (cliente_id, endereco_entrega_id, forma_pagamento, 
                    valor_frete, desconto, valor_total, data_pedido)
                    VALUES (:cliente_id, :endereco_entrega_id, :forma_pagamento, 
                    :valor_frete, :desconto, :valor_total, :data_pedido)";

            $ps = $this->pdo->prepare($sqlPedido);

            $ps->execute([
                ':cliente_id' => $pedido->clienteId,
                ':endereco_entrega_id' => $pedido->enderecoEntregaId,
                ':forma_pagamento' => $pedido->formaPagamento,
                ':valor_frete' => $pedido->valorFrete,
                ':desconto' => $pedido->desconto,
                ':valor_total' => $pedido->valorTotal,
                ':data_pedido' => $pedido->dataPedido
            ]);

            $pedidoId = (int) $this->pdo->lastInsertId();

            $sqlItem = "INSERT into itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario)
                        VALUES (:pedido_id, :variacao_id, :quantidade, :preco_unitario)";

            $psItem = $this->pdo->prepare($sqlItem);

            foreach ($itens as $item) {
                $psItem->execute([
                    ':pedido_id' => $pedidoId,
                    ':variacao_id' => $item->variacaoId,
                    ':quantidade' => $item->quantidade,
                    ':preco_unitario' => $item->precoUnitario
                ]);
            }

            $this->pdo->commit();

            return $pedidoId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erro ao criar o pedido: " . $e->getMessage(), 500);
        }
    }
}

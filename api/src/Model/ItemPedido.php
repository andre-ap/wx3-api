<?php

namespace Src\Model;

class ItemPedido
{
    public int $variacaoId;
    public int $quantidade;
    public float $precoUnitario;

    /**
     * @param array{
     * variacaoId: int,
     * quantidade: int,
     * precoUnitario: float
     * } $dados
     */
    public function __construct(array $dados)
    {
        $this->variacaoId = $dados['variacaoId'];
        $this->quantidade = $dados['quantidade'];
        $this->precoUnitario = $dados['precoUnitario'];
    }
}

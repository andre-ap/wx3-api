<?php

namespace Src\Model;

class ItemPedido
{
    public int $variacaoId;
    public int $quantidade;
    public float $precoUnitario;

    public function __construct(array $dados)
    {
        $this->variacaoId = $dados['variacaoId'];
        $this->quantidade = $dados['quantidade'];
        $this->precoUnitario = $dados['precoUnitario'];
    }
}

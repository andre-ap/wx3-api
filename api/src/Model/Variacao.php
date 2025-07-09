<?php

namespace Src\Model;

class Variacao
{
    public ?int $id;
    public int $produtoId;
    public string $tamanho;
    public int $estoque;
    public float $preco;

    public function __construct(array $dados)
    {
        $this->id = isset($dados['id']) ? (int) $dados['id'] : null;
        $this->produtoId = (int) $dados['produto_id'];
        $this->tamanho = $dados['tamanho'];
        $this->estoque = (int) $dados['estoque'];
        $this->preco = (float) $dados['preco'];
    }
}
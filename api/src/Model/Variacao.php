<?php

namespace Src\Model;

class Variacao
{
    public function __construct(
        public int $produtoId,
        public string $tamanho,
        public int $estoque,
        public ?int $id = null
    ) {}
}
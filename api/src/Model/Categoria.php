<?php

namespace Src\Model;

class Categoria
{
    public function __construct(
        public string $nome,
        public string $descricao,
        public ?int $id = null
    ) {}
}

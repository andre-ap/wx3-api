<?php

namespace Src\Model;

class Produto {
    public function __construct(
        public string $nome,
        public string $cor,
        public string $imagem,
        public float $preco,
        public string $descricao,
        public string $dataCadastro,
        public float $peso,
        public int $categoria,
        public ?int $id = null,
    ) {}
}

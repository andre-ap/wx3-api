<?php

namespace Src\Model;

class Cliente
{
    public function __construct(
        public string $nomeCompleto,
        public string $cpf,
        public string $dataNascimento,
        public ?int $id = null
    ) {}
}

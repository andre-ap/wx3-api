<?php

namespace Src\Model;

class Endereco
{
    public function __construct(
        public int $clienteId,
        public string $logradouro,
        public string $cidade,
        public string $bairro,
        public string $numero,
        public string $cep,
        public ?string $complemento = null,
        public ?int $id = null, 
    ) {}
}

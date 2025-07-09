<?php

namespace Src\Model;

class Endereco
{
    public int $id;
    public int $cliente_id;
    public string $logradouro;
    public string $cidade;
    public string $bairro;
    public string $numero;
    public string $cep;
    public ?string $complemento;

    public function __construct(array $dados)
    {
        $this->id = $dados['id'] ?? 0;
        $this->cliente_id = $dados['cliente_id'];
        $this->logradouro = $dados['logradouro'];
        $this->cidade = $dados['cidade'];
        $this->bairro = $dados['bairro'];
        $this->numero = $dados['numero'];
        $this->cep = $dados['cep'];
        $this->complemento = $dados['complemento'] ?? null;
    }
}

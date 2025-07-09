<?php

namespace Src\Model;

class Cliente
{
    public ?int $id;
    public string $nome_completo;
    public string $cpf;
    public string $data_nascimento;

    /**
     * @param array{
     *   id: int | null,
     *   nome_completo: string,
     *   cpf: string,
     *   data_nascimento: string,
     * } $dados
     */
    public function __construct(array $dados)
    {
        $this->id = $dados['id'] ?? null;
        $this->nome_completo = $dados['nome_completo'];
        $this->cpf = $dados['cpf'];
        $this->data_nascimento = $dados['data_nascimento'];
    }

    
}

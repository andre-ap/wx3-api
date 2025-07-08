<?php

namespace Src\Model;

class Cliente
{
    public ?int $id;
    public string $nome;
    public string $cpf;
    public string $dataNascimento;

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
        $this->nome = $dados['nome_completo'];
        $this->cpf = $dados['cpf'];
        $this->dataNascimento = $dados['data_nascimento'];
    }

    
}

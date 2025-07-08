<?php

namespace Src\Model;

class Categoria
{
    public ?int $id;
    public string $nome;
    public string $descricao;

    /**
     * @param array{
     *   id: int | null,
     *   nome: string,
     *   descricao: string,
     * } $dados
     */
    public function __construct (array $dados){
        $this->id = $dados['id'] ?? null;
        $this->nome = $dados['nome'];
        $this->descricao = $dados['descricao'];
    }
}

<?php

namespace Src\Model;

class Produto
{
    public ?int $id;
    public string $nome;
    public string $cor;
    public string $imagem;
    public float $preco;
    public string $descricao;
    public ?string $dataCadastro;
    public float $peso;
    public int $categoriaId;

    /**
     * Summary of __construct
     * @param array{
     *   id: int,
     *   nome: string,
     *   cor: string,
     *   imagem: string,
     *   preco_base: float,
     *   descricao: string,
     *   data_cadastro: string | null,
     *   peso: float,
     *   categoria_id: int
     * } $dados
     */
    public function __construct(array $dados)
    {
        $this->id = $dados['id'] ?? null;
        $this->nome = $dados['nome'];
        $this->cor = $dados['cor'];
        $this->imagem = $dados['imagem'];
        $this->preco = $dados['preco_base'];
        $this->descricao = $dados['descricao'];
        $this->dataCadastro = $dados['data_cadastro'] ?? null;
        $this->peso = $dados['peso'];
        $this->categoriaId = $dados['categoria_id'];
    }

    
}

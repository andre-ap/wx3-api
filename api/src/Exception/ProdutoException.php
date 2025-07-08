<?php

namespace Src\Exception;

class ProdutoException extends TratadorDeErros 
{
    public static function produtoInexistente (int $id): self 
    {
        return new self("Produto com ID {$id} nao encontrado", 404);
    }

    public static function idInvalido (): self
    {
        return new self ("O id deve ser um número inteiro.", 422);
    }

    public static function nomeInvalido (): self 
    {
        return new self ("O nome do produto deve ter pelo menos 2 caracteres", 422);
    }

    public static function corInvalida (): self 
    {
        return new self ("A cor do produto deve ter pelo menos 3 caracteres", 422);
    }

    public static function precoInvalido (): self
    {
        return new self ("O preço do produto deve ser um número maior que 0.", 422);
    }

    public static function descricaoInvalida (): self 
    {
        return new self ("A descrição do produto deve ter pelo menos 5 caracteres", 422);
    }

    public static function pesoInvalido(): self
    {
        return new self ("O peso do produto deve ser um número maior que 0.", 422);
    }

    public static function categoriaInvalida(): self
    {
        return new self ("O ID da categoria deve ser um número válido", 422);
    }

    public static function categoriaInexistente($id): self
    {
        return new self ("A categoria de id: $id não existe");
    }

}
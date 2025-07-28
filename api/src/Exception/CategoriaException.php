<?php

namespace Src\Exception;

class CategoriaException extends TratadorDeErros 
{
    public static function idInvalido (): self
    {
        return new self ("O id deve ser um número inteiro", 422);
    }

    public static function naoEncontrada(int $id): self
    {
        return new self ("A categoria de id $id não foi encontrada", 404);
    }

    public static function nomeInvalido(): self
    {
        return new self ("O nome da categoria deve ter pelo menos 2 caracteres", 422);
    }

    public static function descricaoInvalida(): self
    {
        return new self ("A descrição da categoria deve ter pelo menos 5 caracteres", 422);
    }

    public static function categoriaInexistente(): self
    {
        return new self("Categoria não encontrada", 404); 
    }

    public static function JsonInvalido(): self
    {
        return new self("Erro interno ao criar resposta para essa requisição");
    }

    public static function parametrosAusentes(): self
    {
        return new self ("Parâmetros obrigatórios ausentes", 400);
    }
}
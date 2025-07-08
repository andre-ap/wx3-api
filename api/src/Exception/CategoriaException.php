<?php

namespace Src\Exception;

class CategoriaException extends TratadorDeErros 
{
    public static function idInvalido (): self
    {
        return new self ("O id deve ser um número inteiro", 422);
    }

    public static function naoEncontrada($id): self
    {
        return new self ("O categoria de id $id não foi encontrada", 404);
    }

    public static function nomeInvalido(): self
    {
        return new self ("O nome do produto deve ter pelo menos 2 caracteres", 422);
    }

    public static function descricaoInvalida(): self
    {
        return new self ("O nome do produto deve ter pelo menos 5 caracteres", 422);
    }

    
}
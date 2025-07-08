<?php

namespace Src\Exception;

class ClienteException extends TratadorDeErros 
{
    public static function idInvalido (): self
    {
        return new self ("O id deve ser um número inteiro", 422);
    }

    public static function nomeInvalido(): self
    {
        return new self ("O nome deve ter mais de 2 caracteres");
    }

    public static function cpfInvalido(): self
    {
        return new self("O cpf deve ser um número de 11 dígitos");
    }
}
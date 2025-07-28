<?php

namespace Src\Exception;

class AuthExcepetion extends TratadorDeErros 
{
    public static function credenciaisEmBranco (): self
    {
        return new self ("O login e senha devem ser informados", 400);
    }

    public static function credenciasInvalidas(): self
    {
        return new self("As credencias informadas são inválidas", 401);
    }

    public static function erroAoCodificar(): self
    {
        return new self ("Erro ao codificar resposta JSON", 500);
    }

    public static function erroAoGerarMensagem(): self
    {
        return new self ("Erro interno ao gerar resposta em JSON", 500);
    }
}
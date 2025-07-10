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
        return new self ("O nome deve ter mais de 2 caracteres", 422);
    }

    public static function cpfInvalido(): self
    {
        return new self("O cpf deve ser uma texto com 14 dígitos Ex: '123.456.789-00' ", 422);
    }

    public static function clienteExistente(): self
    {
        // Erro ao cadastrar cliente? 
        return new self ("O cliente com o CPF informado já foi cadastrado", 409);
    }

    public static function clienteInexistente():self
    {
        return new self ("O cliente buscado não existe", 404);
    }
}
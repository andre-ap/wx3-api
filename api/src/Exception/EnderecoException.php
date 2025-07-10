<?php
namespace Src\Exception;

use Exception;

class EnderecoException extends Exception
{
    public static function idInvalido(): self
    {
        return new self("ID do endereço inválido.", 422);
    }

    public static function clienteIdInvalido(): self
    {
        return new self("ID do cliente associado ao endereço inválido.", 422);
    }

    public static function logradouroInvalido(): self
    {
        return new self("Logradouro inválido ou muito curto.", 422);
    }

    public static function cidadeInvalida(): self
    {
        return new self("Cidade inválida ou muito curta.", 422);
    }

    public static function bairroInvalido(): self
    {
        return new self("Bairro inválido ou muito curto.", 422);
    }

    public static function numeroInvalido(): self
    {
        return new self("Número do endereço inválido.", 422);
    }

    public static function cepInvalido(): self
    {
        return new self("CEP inválido. Deve conter 8 dígitos.", 422);
    }

    public static function complementoInvalido(): self
    {
        return new self("Complemento do endereço inválido.", 422);
    }

    public static function enderecoNaoEncontrado(): self
    {
        return new self("Endereço não encontrado.", 404);
    }
}
<?php

namespace Src\Exception;

use Exception;

class VariacaoException extends Exception
{
    public static function idInvalido(): self
    {
        return new self("ID da variação inválido", 422);
    }

    public static function variacaoNaoEncontrada(): self
    {
        return new self("Variação não encontrada", 404);
    }

    public static function produtoIdInvalido(): self
    {
        return new self("ID do produto inválido", 422);
    }

    public static function tamanhoInvalido(): self
    {
        return new self("Tamanho da variação inválido ou muito curto.", 422);
    }

    public static function estoqueInvalido(): self
    {
        return new self("Estoque inválido. Deve ser um número inteiro não negativo.", 422);
    }

    public static function precoInvalido(): self
    {
        return new self("Preço inválido. Deve ser um número positivo.", 422);
    }

    public static function variacaoExistente(): self
    {
        return new self("Já existe uma variação com este produto e tamanho.", 409);
    }

    public static function JsonInvalido(): self
    {
        return new self("Erro ao codificar a resposta em JSON", 500);
    }

    public static function parametrosAusentes(): self
    {
        return new self("Parâmetros obrigatórios ausentes", 400);
    }
}

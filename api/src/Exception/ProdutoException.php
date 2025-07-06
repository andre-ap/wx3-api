<?php

namespace Src\Exception;

class ProdutoException extends TratadorDeErros {
    public static function erroAoMontarObjeto(): self
    {
        return new self("Erro ao montar objeto Produto", 500);
    }

    public static function erroAoAcessarBD(): self{
        return new self("Erro ao acessar banco de dados", 500);
    }
}
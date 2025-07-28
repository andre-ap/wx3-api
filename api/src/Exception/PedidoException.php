<?php

namespace Src\Exception;

use Src\Exception\TratadorDeErros;

class PedidoException extends TratadorDeErros
{
    public static function idInvalido(): self
    {
        return new self("ID inválido.", 422);
    }

    public static function clienteInvalido(): self
    {
        return new self("Cliente inválido.", 422);
    }

    public static function clienteInexistente(): self
    {
        return new self ("Cliente não cadastrado.", 404);
    }

    public static function enderecoInvalido(): self
    {
        return new self("Endereço de entrega inválido.", 422);
    }

    public static function enderecoInexistente(): self
    {
        return new self ("Endereço não cadastrado.", 404);
    }

    public static function formaPagamentoInvalida(): self
    {
        return new self("Forma de pagamento inválida.", 422);
    }

    public static function freteInvalido(): self
    {
        return new self("Valor do frete inválido.", 422);
    }

    public static function descontoInvalido(): self
    {
        return new self("Valor do desconto inválido.", 422);
    }

    public static function valorTotalInvalido(): self
    {
        return new self("Valor total inválido.", 422);
    }

    public static function pedidoNaoEncontrado(int $id): self
    {
        return new self("Pedido $id não encontrado.", 404);
    }

    public static function itensInvalidos(): self
    {
        return new self ("Os itens precisam estar em um array.", 422);
    }

    public static function variacaoInvalida(): self
    {
        return new self ("O id das variações precisam ser números maiores que 0", 422);
    }

    public static function variacaoInexistente(): self
    {
        return new self ("A variação procurada não existe.", 404);
    } 

    public static function variacaoInsuficiente(): self
    {
        return new self ("Quantidade insuficiente de itens no estoque.", 422);
    }

    public static function jsonInvalido(): self
    {
        return new self ("Erro interno ao criar resposta para essa requisição", 500);
    }

    public static function parametrosAusentes(): self
    {
        return new self ("Parâmetros obrigatórios ausentes", 400);
    }
}

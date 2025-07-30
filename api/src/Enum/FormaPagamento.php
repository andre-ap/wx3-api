<?php

namespace Src\Enum;

enum FormaPagamento: string
{
    case PIX = 'PIX';
    case BOLETO = 'BOLETO';
    case CARTAO_1X = 'CARTAO_1X';
}
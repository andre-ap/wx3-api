<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\PedidoService;

class PedidoController
{
    private PedidoService $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novoPedidoId = $this->service->criarNovoPedido($dados);

        $response->getBody()->write(json_encode($novoPedidoId));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
}
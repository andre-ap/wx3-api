<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\PedidoException;
use Src\Service\PedidoService;

class PedidoController
{
    private PedidoService $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) || 
            !isset($dados['clienteId']) || 
            !isset($dados['enderecoEntregaId']) || 
            !isset($dados['formaPagamento']) || 
            !isset($dados['itens'])
        ) {
            throw PedidoException::parametrosAusentes();
        }

        $novoPedidoId = $this->service->criarNovoPedido($dados);

        $respostaJson = json_encode($novoPedidoId);

        if ($respostaJson === false) {
            throw PedidoException::jsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
}

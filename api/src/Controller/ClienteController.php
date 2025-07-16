<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\ClienteService;

class ClienteController
{
    private ClienteService $service;

    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response
    {
        $clientes = $this->service->listarClientes();

        $response->getBody()->write(json_encode($clientes));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $cliente = $this->service->buscarClientePorID($id);
        
        $response->getBody()->write(json_encode($cliente));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novoClienteId = $this->service->criarNovoCliente($dados);

        $response->getBody()->write($novoClienteId);
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $dados = $request->getParsedBody();
        $clienteAtualizado = $this->service->atualizarCliente($id, $dados);

        $response->getBody()->write($clienteAtualizado);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $clienteRemovido = $this->service->removerCliente($id);

        $response->getBody()->write($clienteRemovido);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

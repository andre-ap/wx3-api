<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\EnderecoService;

class EnderecoController
{

    private EnderecoService $service;

    public function __construct(EnderecoService $service)
    {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response
    {
        $enderecos = $this->service->listarEnderecos();

        $response->getBody()->write(json_encode($enderecos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $endereco = $this->service->buscarEnderecoPorId($id);

        $response->getBody()->write(json_encode($endereco));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novoEnderecoId = $this->service->criarNovoEndereco($dados);

        $response->getBody()->write(json_encode($novoEnderecoId));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $dados = $request->getParsedBody();
        $enderecoAtualizado = $this->service->atualizarEndereco($id, $dados);

        $response->getBody()->write(json_encode($enderecoAtualizado));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $enderecoRemovido = $this->service->removerEnderecoPorId($id);

        $response->getBody()->write(json_encode($enderecoRemovido));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\VariacaoService;

class VariacaoController
{
    private VariacaoService $service;

    public function __construct(VariacaoService $service)
    {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response
    {
        $variacoes = $this->service->listarVariacoes();

        $response->getBody()->write(json_encode($variacoes));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $variacao = $this->service->buscarVariacaoPorId($id);

        $response->getBody()->write(json_encode($variacao));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novaVariacaoId = $this->service->criarNovaVariacao($dados);

        $response->getBody()->write($novaVariacaoId);
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $dados = $request->getParsedBody();
        $variacaoAtualizada = $this->service->atualizarVariacao($id, $dados);

        $response->getBody()->write($variacaoAtualizada);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $variacaoRemovida = $this->service->removerVariacaoPorId($id);

        $response->getBody()->write($variacaoRemovida);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

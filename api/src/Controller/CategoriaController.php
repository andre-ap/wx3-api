<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\CategoriaService;

class CategoriaController
{
    private CategoriaService $service;

    public function __construct(CategoriaService $service)
    {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response
    {
        $categorias = $this->service->listarTodasCategorias();
        $response->getBody()->write(json_encode($categorias));
        
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $categoria = $this->service->buscarCategoriaPorId($id);

        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novaCategoriaId = $this->service->criarNovaCategoria($dados);

        $response->getBody()->write(json_encode($novaCategoriaId));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $dados = $request->getParsedBody();
        $linhasAfetadas = $this->service->atualizarCategoria($id, $dados);

        $response->getBody()->write($linhasAfetadas);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function remover(Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $linhasAfetadas = $this->service->removerItemPorID($id);

        $response->getBody()->write($linhasAfetadas);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

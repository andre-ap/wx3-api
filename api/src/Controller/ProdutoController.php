<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Service\ProdutoService;

class ProdutoController
{
    private ProdutoService $service;

    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function listar(Request $request, Response $response): Response
    {
        $produtos = $this->service->listarTodosProdutos();
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $produto = $this->service->buscarProdutoPorId($id);
        $response->getBody()->write(json_encode($produto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();
        $novoProdutoId = $this->service->criarNovoProduto($dados);
        
        $response->getBody()->write(json_encode($novoProdutoId));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $dados = $request->getParsedBody();
        $produtoAtualizado = $this->service->atualizarProduto($id, $dados);
        
        $response->getBody()->write(json_encode($produtoAtualizado));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $produtoRemovido = $this->service->removerProduto($id);
        
        $response->getBody()->write(json_encode($produtoRemovido));
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}
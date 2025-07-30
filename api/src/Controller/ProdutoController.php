<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\ProdutoException;
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

        $respostaJson = json_encode($produtos);

        if ($respostaJson === false) {
            throw ProdutoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array<string, string> $args
     * @return Response
     */
    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $produto = $this->service->buscarProdutoPorId($id);

        $respostaJson = json_encode($produto);

        if ($respostaJson === false) {
            throw ProdutoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
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

        if (
            !is_array($dados) ||
            !isset($dados['nome']) ||
            !isset($dados['cor']) ||
            !isset($dados['imagem']) ||
            !isset($dados['preco']) ||
            !isset($dados['descricao']) ||
            !isset($dados['peso']) ||
            !isset($dados['categoriaId'])
        ) {
            throw ProdutoException::parametrosAusentes();
        }

        $produto = [
            'nome' => (string) $dados['nome'],
            'cor' => (string) $dados['cor'],
            'imagem' => (string) $dados['imagem'],
            'preco' => (float) $dados['preco'],
            'descricao' => (string) $dados['descricao'],
            'peso' => (float) $dados['peso'],
            'categoriaId' => (int) $dados['categoriaId'],
        ];

        $novoProdutoId = $this->service->criarNovoProduto($produto);

        $respostaJson = json_encode($novoProdutoId);

        if ($respostaJson === false) {
            throw ProdutoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array<string, string> $args
     * @return Response
     */
    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) ||
            !isset($dados['nome']) ||
            !isset($dados['cor']) ||
            !isset($dados['imagem']) ||
            !isset($dados['preco']) ||
            !isset($dados['descricao']) ||
            !isset($dados['peso']) ||
            !isset($dados['categoriaId'])
        ) {
            throw ProdutoException::parametrosAusentes();
        }

        $produto = [
            'nome' => (string) $dados['nome'],
            'cor' => (string) $dados['cor'],
            'imagem' => (string) $dados['imagem'],
            'preco' => (float) $dados['preco'],
            'descricao' => (string) $dados['descricao'],
            'peso' => (float) $dados['peso'],
            'categoriaId' => (int) $dados['categoriaId'],
        ];

        $produtoAtualizado = $this->service->atualizarProduto($id, $produto);

        $respostaJson = json_encode($produtoAtualizado);

        if ($respostaJson === false) {
            throw ProdutoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array<string, string> $args
     * @return Response
     */
    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];
        $produtoRemovido = $this->service->removerProduto($id);

        $respostaJson = json_encode($produtoRemovido);

        if ($respostaJson === false) {
            throw ProdutoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}

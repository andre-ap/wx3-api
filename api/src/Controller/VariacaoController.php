<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\VariacaoException;
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
        $respostaJson = json_encode($variacoes);

        if ($respostaJson === false) {
            throw VariacaoException::JsonInvalido();
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
        $id = (int)$args['id'];
        $variacao = $this->service->buscarVariacaoPorId($id);

        $respostaJson = json_encode($variacao);

        if ($respostaJson === false) {
            throw VariacaoException::JsonInvalido();
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
            !isset($dados['produtoId']) ||
            !isset($dados['tamanho']) ||
            !isset($dados['estoque'])
        ) {
            throw VariacaoException::parametrosAusentes();
        }

        $variacao = [
            'produtoId' => (int) $dados['produtoId'],
            'tamanho' => (string) $dados['tamanho'],
            'estoque' => (int) $dados['estoque'],
        ];

        $novaVariacaoId = $this->service->criarNovaVariacao($variacao);

        $respostaJson = json_encode($novaVariacaoId);

        if ($respostaJson === false) {
            throw VariacaoException::JsonInvalido();
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
        $id = (int)$args['id'];
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) ||
            !isset($dados['produtoId']) ||
            !isset($dados['tamanho']) ||
            !isset($dados['estoque'])
        ) {
            throw VariacaoException::parametrosAusentes();
        }

        $variacao = [
            'produtoId' => (int) $dados['produtoId'],
            'tamanho' => (string) $dados['tamanho'],
            'estoque' => (int) $dados['estoque'],
        ];

        $variacaoAtualizada = $this->service->atualizarVariacao($id, $variacao);

        $respostaJson = json_encode($variacaoAtualizada);

        if ($respostaJson === false) {
            throw VariacaoException::JsonInvalido();
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
    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $variacaoRemovida = $this->service->removerVariacaoPorId($id);

        $respostaJson = json_encode($variacaoRemovida);

        if ($respostaJson === false) {
            throw VariacaoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

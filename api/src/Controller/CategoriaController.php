<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\CategoriaException;
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
        $respostaJson = json_encode($categorias);

        if ($respostaJson === false) {
            throw CategoriaException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param array<string, string> $args
     */
    public function buscar(Request $request, Response $response, array $args): Response
    {
        $id = (int)($args['id'] ?? 0);

        $categoria = $this->service->buscarCategoriaPorId($id);
        $respostaJson = json_encode($categoria);

        if ($respostaJson === false) {
            throw CategoriaException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        if (!is_array($dados) || !isset($dados['nome']) || !isset($dados['descricao'])) {
            throw CategoriaException::JsonInvalido();
        }

        $novaCategoria = [
            'nome' => (string) $dados['nome'],
            'descricao' => (string) $dados['descricao'],
        ];

        $novaCategoriaId = $this->service->criarNovaCategoria($novaCategoria);
        $respostaJson = json_encode($novaCategoriaId);

        if ($respostaJson === false) {
            throw CategoriaException::JsonInvalido();
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
        $id = (int)($args['id'] ?? 0);
        $dados = $request->getParsedBody();

        if (!is_array($dados) || !isset($dados['nome']) || !isset($dados['descricao'])) {
            throw CategoriaException::parametrosAusentes();
        }

        $dadosCategoria = [
            'nome' => (string) $dados['nome'],
            'descricao' => (string) $dados['descricao'],
        ];

        $linhasAfetadas = $this->service->atualizarCategoria($id, $dadosCategoria);
        $respostaJson = json_encode($linhasAfetadas);

        if ($respostaJson === false) {
            throw CategoriaException::jsonInvalido();
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
        $id = (int)($args['id'] ?? 0);
        $linhasAfetadas = $this->service->removerItemPorID($id);

        $respostaJson = json_encode($linhasAfetadas);

        if ($respostaJson === false) {
            throw CategoriaException::jsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\EnderecoException;
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

        $respostaJson = json_encode($enderecos);

        if ($respostaJson === false) {
            throw EnderecoException::JsonInvalido();
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
        $endereco = $this->service->buscarEnderecoPorId($id);

        $respostaJson = json_encode($endereco);

        if ($respostaJson === false) {
            throw EnderecoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) ||
            !isset($dados['clienteId']) ||
            !isset($dados['logradouro']) ||
            !isset($dados['cidade']) ||
            !isset($dados['bairro']) ||
            !isset($dados['numero']) ||
            !isset($dados['cep'])
        ) {
            throw EnderecoException::parametrosAusentes();
        }

        $endereco = [
            'clienteId' => (int) $dados['clienteId'],
            'logradouro' => (string) $dados['logradouro'],
            'cidade' => (string) $dados['cidade'],
            'bairro' => (string) $dados['bairro'],
            'numero' => (string) $dados['numero'],
            'cep' => (string) $dados['cep'],
            'complemento' => (string) ($dados['complemento'] ?? ''),
        ];

        $novoEnderecoId = $this->service->criarNovoEndereco($endereco);
        $respostaJson = json_encode($novoEnderecoId);

        if ($respostaJson === false) {
            throw EnderecoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param array<string, string> $args
     */
    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = (int)($args['id'] ?? 0);
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) ||
            !isset($dados['logradouro']) ||
            !isset($dados['cidade']) ||
            !isset($dados['bairro']) ||
            !isset($dados['numero']) ||
            !isset($dados['cep']) ||
            !isset($dados['clienteId'])
        ) {
            throw EnderecoException::parametrosAusentes();
        }

        $endereco = [
            'logradouro' => (string) $dados['logradouro'],
            'cidade' => (string) $dados['cidade'],
            'bairro' => (string) $dados['bairro'],
            'numero' => (string) $dados['numero'],
            'cep' => (string) $dados['cep'],
            'complemento' => (string) ($dados['complemento'] ?? ''),
            'clienteId' => (int) $dados['clienteId'],
        ];

        $enderecoAtualizado = $this->service->atualizarEndereco($id, $endereco);

        $respostaJson = json_encode($enderecoAtualizado);

        if ($respostaJson === false) {
            throw EnderecoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param array<string, string> $args
     */
    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $enderecoRemovido = $this->service->removerEnderecoPorId($id);

        $respostaJson = json_encode($enderecoRemovido);

        if ($respostaJson === false) {
            throw EnderecoException::JsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

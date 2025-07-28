<?php

namespace Src\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Exception\ClienteException;
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

        $respostaJson = json_encode($clientes);

        if ($respostaJson === false) {
            throw ClienteException::jsonInvalido();
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
        $cliente = $this->service->buscarClientePorID($id);

        $respostaJson = json_encode($cliente);

        if ($respostaJson === false) {
            throw ClienteException::jsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response
    {
        $dados = $request->getParsedBody();

        if (
            !is_array($dados) ||
            !isset($dados['nomeCompleto']) ||
            !isset($dados['cpf']) ||
            !isset($dados['dataNascimento'])
        ) {
            throw ClienteException::parametrosAusentes();
        }

        $cliente = [
            'nomeCompleto' => (string) $dados['nomeCompleto'],
            'cpf' => (string) $dados['cpf'],
            'dataNascimento' => (string) $dados['dataNascimento'],
        ];

        $novoClienteId = $this->service->criarNovoCliente($cliente);

        $respostaJson = json_encode($novoClienteId);

        if ($respostaJson === false) {
            throw ClienteException::jsonInvalido();
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
            !isset($dados['nomeCompleto']) ||
            !isset($dados['cpf']) ||
            !isset($dados['dataNascimento'])
        ) {
            throw ClienteException::parametrosAusentes();
        }

        $clienteAtualizado = $this->service->atualizarCliente($id, $dados);

        $respostaJson = json_encode($clienteAtualizado);

        if ($respostaJson === false) {
            throw ClienteException::jsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param array<string, string> $args
     */
    public function remover(Request $request, Response $response, array $args): Response
    {
        $id = (int)($args['id'] ?? 0);
        $clienteRemovido = $this->service->removerCliente($id);

        $respostaJson = json_encode($clienteRemovido);

        if ($respostaJson === false) {
            throw ClienteException::jsonInvalido();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

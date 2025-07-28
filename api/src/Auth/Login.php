<?php

namespace Src\Auth;

use Exception;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\DAO\LoginDAO;
use Src\Exception\AuthExcepetion;

class Login
{
    private LoginDAO $dao;

    public function __construct(LoginDAO $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param array<string, mixed> $args
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        $dados = $request->getParsedBody();

        if(!is_array($dados) || !isset($dados["cpf"]) || !isset($dados["senha"])){
            throw AuthExcepetion::credenciaisEmBranco();
        }

        $cpf = (string) $dados["cpf"];
        $senha = (string) $dados["senha"];

        $funcionario = $this->dao->login($cpf);

        $senhaUsandoSalPimenta = $funcionario['sal'] . $senha . $_ENV["PIMENTA"];
        $hash = hash('sha512', $senhaUsandoSalPimenta);

        if ($funcionario['senha_hash'] !== $hash) {
            throw AuthExcepetion::credenciasInvalidas();
        }

        $payload = [
            "exp" => time() + 3600,
            "iat" => time(),
            "cpf" => $cpf
        ];

        $encode = JWT::encode($payload, $_ENV['CHAVE'], 'HS256');

        $respostaJson = json_encode(['token' => $encode]);

        if ($respostaJson == false){
            throw AuthExcepetion::erroAoCodificar();
        }

        $response->getBody()->write($respostaJson);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

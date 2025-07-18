<?php

namespace Src\Auth;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Src\DAO\LoginDAO;

class Login
{
    private $dao;

    public function __construct(LoginDAO $dao)
    {
        $this->dao = $dao;
    }

    public function login(Request $request, Response $response, array $args)
    {
        $dados = $request->getParsedBody();
        $cpf = $dados["cpf"];
        $senha = $dados["senha"];

        $funcionario = $this->dao->login($cpf);

        $senhaUsandoSalPimenta = $funcionario['sal'] . $senha . $_ENV["PIMENTA"];
        $hash = hash('sha512', $senhaUsandoSalPimenta);

        if ($funcionario['senha_hash'] !== $hash) {
            return $response->withStatus(401);
        }

        $payload = [
            "exp" => time() + 3600,
            "iat" => time(),
            "cpf" => $cpf
        ];

        $encode = JWT::encode($payload, $_ENV['CHAVE'], 'HS256');

        $response->getBody()->write(json_encode(['token' => $encode]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

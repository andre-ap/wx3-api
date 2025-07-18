<?php

namespace Src\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class MiddlewareJWT implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $auth = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $auth);

        if (!$token) {
            $response = new Response();
            $response->getBody()->write(json_encode(['erro' => 'Token ausente']));
            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }

        try {
            $decoded = JWT::decode($token, new Key($_ENV['CHAVE'], 'HS256'));
        } catch (\Throwable $e) {
            $response = new Response();
            $mensagem = $e->getMessage();

            if (strpos(strtolower($mensagem), 'expired') !== false) {
                $mensagem = 'Token expirado';
            }

            $response->getBody()->write(json_encode(['erro' => $mensagem]));
            return $response
                ->withStatus(401)
                ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }

        return $handler->handle($request);
    }
}

<?php 

declare (strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Config\ConexaoDB;
use Src\Exception\TratadorDeErros;
use Src\Controller\ProdutoController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/api/produtos', function (Request $request, Response $response){
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);
    $produtos = $controller->listar();

    $response->getBody()->write(json_encode($produtos));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
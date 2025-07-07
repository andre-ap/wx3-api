<?php 

declare (strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Config\ConexaoDB;
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

$app->get('/api/produtos/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);
    $produto = $controller->buscar($id);
    
    $response->getBody()->write(json_encode($produto));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/produtos', function (Request $request, Response $response, array $args) {
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novoProduto = $controller->criar($dados);

    $response->getBody()->write(json_encode($novoProduto));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/produtos/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);

    $controller->atualizar($id, $dados);
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->run();
<?php 

declare (strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Config\ConexaoDB;
use Src\Controller\CategoriaController;
use Src\Controller\ProdutoController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');

// === PRODUTOS ===
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

$app->post('/api/produtos', function (Request $request, Response $response) {
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

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/produtos/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

// === CATEGORIAS ===
$app->get('/api/categorias', function (Request $request, Response $response){
    $pdo = ConexaoDB::conectar();
    $controller = new CategoriaController($pdo);
    $categorias = $controller->listar();

    $response->getBody()->write(json_encode($categorias));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/categorias/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new CategoriaController($pdo);
    $categorias = $controller->buscar($id);
    
    $response->getBody()->write(json_encode($categorias));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/categorias', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new CategoriaController($pdo);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novaCategoria = $controller->criar($dados);

    $response->getBody()->write(json_encode($novaCategoria));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/categorias/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $controller = new CategoriaController($pdo);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/categorias/{id}', function (Request $request, Response $response, array $args){
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new CategoriaController($pdo);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->run();
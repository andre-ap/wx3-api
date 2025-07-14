<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Src\Config\ConexaoDB;
use Src\Controller\CategoriaController;
use Src\Controller\ClienteController;
use Src\Controller\EnderecoController;
use Src\Controller\PedidoController;
use Src\Controller\ProdutoController;
use Src\Controller\VariacaoController;
use Src\DAO\CategoriaDAO;
use Src\DAO\ClienteDAO;
use Src\Service\CategoriaService;
use Src\Service\ClienteService;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');

// === PRODUTOS ===
$app->get('/api/produtos', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);
    $produtos = $controller->listar();

    $response->getBody()->write(json_encode($produtos));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
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

$app->put('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/produtos/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new ProdutoController($pdo);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

// === CATEGORIAS ===
$app->get('/api/categorias', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $dao = new CategoriaDAO($pdo);
    $service = new CategoriaService($dao);
    $controller = new CategoriaController($service);

    $categorias = $controller->listar();

    $response->getBody()->write(json_encode($categorias));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/categorias/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $dao = new CategoriaDAO($pdo);
    $service = new CategoriaService($dao);
    $controller = new CategoriaController($service);

    $categoria = $controller->buscar($id);
    $response->getBody()->write(json_encode($categoria));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/categorias', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $dao = new CategoriaDAO($pdo);
    $service = new CategoriaService($dao);
    $controller = new CategoriaController($service);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novaCategoria = $controller->criar($dados);

    $response->getBody()->write(json_encode($novaCategoria));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/categorias/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $dao = new CategoriaDAO($pdo);
    $service = new CategoriaService($dao);
    $controller = new CategoriaController($service);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/categorias/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $dao = new CategoriaDAO($pdo);
    $service = new CategoriaService($dao);
    $controller = new CategoriaController($service);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

// === CLIENTES ===
$app->get('/api/clientes', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $dao = new ClienteDAO($pdo);
    $service = new ClienteService($dao);
    $controller = new ClienteController($service);

    $categorias = $controller->listar();
    $response->getBody()->write(json_encode($categorias));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/clientes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $dao = new ClienteDAO($pdo);
    $service = new ClienteService($dao);
    $controller = new ClienteController($service);

    $cliente = $controller->buscar($id);
    $response->getBody()->write(json_encode($cliente));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/clientes', function (Request $request, Response $response) {
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $dao = new ClienteDAO($pdo);
    $service = new ClienteService($dao);
    $controller = new ClienteController($service);

    $novoCliente = $controller->criar($dados);
    $response->getBody()->write(json_encode($novoCliente));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/clientes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $dao = new ClienteDAO($pdo);
    $service = new ClienteService($dao);
    $controller = new ClienteController($service);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/clientes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $dao = new ClienteDAO($pdo);
    $service = new ClienteService($dao);
    $controller = new ClienteController($service);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

// === ENDEREÇO ===
$app->get('/api/enderecos', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new EnderecoController($pdo);
    $enderecos = $controller->listar();

    $response->getBody()->write(json_encode($enderecos));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/enderecos/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new EnderecoController($pdo);
    $endereco = $controller->buscar($id);

    $response->getBody()->write(json_encode($endereco));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/enderecos', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new EnderecoController($pdo);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novoEndereco = $controller->criar($dados);

    $response->getBody()->write(json_encode($novoEndereco));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/enderecos/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $controller = new EnderecoController($pdo);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/enderecos/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new EnderecoController($pdo);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

// === VARIAÇÕES ===
$app->get('/api/variacoes', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new VariacaoController($pdo);
    $variacoes = $controller->listar();

    $response->getBody()->write(json_encode($variacoes));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/variacoes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new VariacaoController($pdo);
    $variacao = $controller->buscar($id);

    $response->getBody()->write(json_encode($variacao));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/variacoes', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new VariacaoController($pdo);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novaVariacao = $controller->criar($dados);

    $response->getBody()->write(json_encode($novaVariacao));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->put('/api/variacoes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $dados = json_decode($request->getBody()->getContents(), true);
    $pdo = ConexaoDB::conectar();
    $controller = new VariacaoController($pdo);

    $idAtualizado = $controller->atualizar($id, $dados);
    $response->getBody()->write(json_encode(['id' => $idAtualizado]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/variacoes/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $pdo = ConexaoDB::conectar();
    $controller = new VariacaoController($pdo);

    $idRemovido = $controller->remover($id);
    $response->getBody()->write(json_encode(['id' => $idRemovido]));
    return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
});

$app->post('/api/pedidos', function (Request $request, Response $response) {
    $pdo = ConexaoDB::conectar();
    $controller = new PedidoController($pdo);
    $dados = json_decode($request->getBody()->getContents(), true);
    $novaVariacao = $controller->criar($dados);

    $response->getBody()->write(json_encode($novaVariacao));
    return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
});

$app->run();

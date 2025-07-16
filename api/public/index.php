<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Src\Controller\CategoriaController;
use Src\Controller\ClienteController;
use Src\Controller\EnderecoController;
use Src\Controller\PedidoController;
use Src\Controller\ProdutoController;
use Src\Controller\VariacaoController;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../src/Config/Dependecias.php';

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

// === PRODUTOS ===
$app->group('/api/produtos', function ($app) {
    $app->get('', [ProdutoController::class, 'listar']);
    $app->get('/{id}', [ProdutoController::class, 'buscar']);
    $app->post('', [ProdutoController::class, 'criar']);
    $app->put('/{id}', [ProdutoController::class, 'atualizar']);
    $app->delete('/{id}', [ProdutoController::class, 'remover']);
});

// === CATEGORIAS ===
$app->group('/api/categorias', function ($app) {
    $app->get('', [CategoriaController::class, 'listar']);
    $app->get('/{id}', [CategoriaController::class, 'buscar']);
    $app->post('', [CategoriaController::class, 'criar']);
    $app->put('/{id}', [CategoriaController::class, 'atualizar']);
    $app->delete('/{id}', [CategoriaController::class, 'remover']);
});

// === CLIENTES ===
$app->group('/api/clientes', function ($app) {
    $app->get('', [ClienteController::class, 'listar']);
    $app->get('/{id}', [ClienteController::class, 'buscar']);
    $app->post('', [ClienteController::class, 'criar']);
    $app->put('/{id}', [ClienteController::class, 'atualizar']);
    $app->delete('/{id}', [ClienteController::class, 'remover']);
});

// === ENDEREÇOS ===
$app->group('/api/enderecos', function ($app) {
    $app->get('', [EnderecoController::class, 'listar']);
    $app->get('/{id}', [EnderecoController::class, 'buscar']);
    $app->post('', [EnderecoController::class, 'criar']);
    $app->put('/{id}', [EnderecoController::class, 'atualizar']);
    $app->delete('/{id}', [EnderecoController::class, 'remover']);
});

// === VARIAÇÕES ===
$app->group('/api/variacoes', function ($app) {
    $app->get('', [VariacaoController::class, 'listar']);
    $app->get('/{id}', [VariacaoController::class, 'buscar']);
    $app->post('', [VariacaoController::class, 'criar']);
    $app->put('/{id}', [VariacaoController::class, 'atualizar']);
    $app->delete('/{id}', [VariacaoController::class, 'remover']);
});

// === PEDIDOS ===
$app->post('/api/pedidos', [PedidoController::class, 'criar']);

$app->run();
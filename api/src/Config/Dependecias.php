<?php

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Src\Config\ConexaoDB;
use Src\DAO\CategoriaDAO;
use Src\DAO\ClienteDAO;
use Src\DAO\EnderecoDAO;
use Src\DAO\PedidoDAO;
use Src\DAO\ProdutoDAO;
use Src\DAO\VariacaoDAO;
use Src\Controller\CategoriaController;
use Src\Controller\ClienteController;
use Src\Controller\EnderecoController;
use Src\Controller\PedidoController;
use Src\Controller\ProdutoController;
use Src\Controller\VariacaoController;
use Src\Service\CategoriaService;
use Src\Service\ClienteService;
use Src\Service\EnderecoService;
use Src\Service\PedidoService;
use Src\Service\ProdutoService;
use Src\Service\VariacaoService;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    PDO::class => function () {
        return ConexaoDB::conectar();
    },

    CategoriaDao::class => function (Container $c) {
        return new CategoriaDao($c->get(PDO::class));
    },
    ClienteDao::class => function (Container $c) {
        return new ClienteDao($c->get(PDO::class));
    },
    EnderecoDao::class => function (Container $c) {
        return new EnderecoDao($c->get(PDO::class));
    },
    PedidoDao::class => function (Container $c) {
        return new PedidoDao($c->get(PDO::class));
    },
    ProdutoDao::class => function (Container $c) {
        return new ProdutoDao($c->get(PDO::class));
    },
    VariacaoDao::class => function (Container $c) {
        return new VariacaoDao($c->get(PDO::class));
    },

    CategoriaService::class => function (Container $c) {
        return new CategoriaService($c->get(CategoriaDao::class));
    },
    ClienteService::class => function (Container $c) {
        return new ClienteService($c->get(ClienteDao::class));
    },
    EnderecoService::class => function (Container $c) {
        return new EnderecoService($c->get(EnderecoDao::class));
    },
    ProdutoService::class => function (Container $c) {
        return new ProdutoService($c->get(ProdutoDao::class), $c->get(CategoriaService::class));
    },
    VariacaoService::class => function (Container $c) {
        return new VariacaoService($c->get(VariacaoDao::class));
    },

    PedidoService::class => function (Container $c) {
        return new PedidoService(
            $c->get(PedidoDao::class),
            $c->get(ClienteService::class),
            $c->get(EnderecoService::class),
            $c->get(VariacaoService::class)
        );
    },

    CategoriaController::class => function (Container $c) {
        return new CategoriaController($c->get(CategoriaService::class));
    },
    ClienteController::class => function (Container $c) {
        return new ClienteController($c->get(ClienteService::class));
    },
    EnderecoController::class => function (Container $c) {
        return new EnderecoController($c->get(EnderecoService::class));
    },
    PedidoController::class => function (Container $c) {
        return new PedidoController($c->get(PedidoService::class));
    },
    ProdutoController::class => function (Container $c) {
        return new ProdutoController($c->get(ProdutoService::class));
    },
    VariacaoController::class => function (Container $c) {
        return new VariacaoController($c->get(VariacaoService::class));
    },
]);

return $containerBuilder->build();
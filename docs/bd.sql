CREATE DATABASE acme;
USE acme;

DROP TABLE IF EXISTS itens_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS variacoes;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS categorias;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cor VARCHAR(50),
    imagem VARCHAR(255),
    descricao TEXT,
    data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    peso DECIMAL(10,2),
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB;

CREATE TABLE variacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    preco DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(150) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    logradouro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    complemento VARCHAR(100),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
) ENGINE=InnoDB;

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    endereco_entrega_id INT NOT NULL,
    forma_pagamento ENUM('PIX', 'BOLETO', 'CARTAO_1X') NOT NULL,
    valor_frete DECIMAL(10,2) NOT NULL,
    desconto DECIMAL(10,2) DEFAULT 0,
    valor_total DECIMAL(10,2) NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (endereco_entrega_id) REFERENCES enderecos(id)
) ENGINE=InnoDB;

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    variacao_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (variacao_id) REFERENCES variacoes(id)
) ENGINE=InnoDB;

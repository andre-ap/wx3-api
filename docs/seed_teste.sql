USE acme_teste;

SET foreign_key_checks = 0;

DELETE FROM itens_pedido;
DELETE FROM pedidos;
DELETE FROM enderecos;
DELETE FROM clientes;
DELETE FROM variacoes;
DELETE FROM produtos;
DELETE FROM categorias;

ALTER TABLE categorias AUTO_INCREMENT = 1;
ALTER TABLE produtos AUTO_INCREMENT = 1;
ALTER TABLE variacoes AUTO_INCREMENT = 1;
ALTER TABLE clientes AUTO_INCREMENT = 1;
ALTER TABLE enderecos AUTO_INCREMENT = 1;
ALTER TABLE pedidos AUTO_INCREMENT = 1;
ALTER TABLE itens_pedido AUTO_INCREMENT = 1;

SET foreign_key_checks = 1;

INSERT INTO
    categorias (nome, descricao)
VALUES
    (
        'Roupas',
        'Roupas para treino e atividade física'
    ),
    ('Calçados', 'Tênis e sapatos esportivos'),
    (
        'Acessórios',
        'Itens complementares como bonés, mochilas, etc'
    );

INSERT INTO
    produtos (nome, cor, imagem, preco, descricao, peso, categoria_id)
VALUES
    (
        'Camiseta Dry Fit',
        'Branca',
        'camiseta.jpg',
        59.90,
        'Camiseta leve e respirável para treino.',
        0.25,
        1
    ),
    (
        'Tênis Corrida Pro',
        'Preto',
        'tenis.jpg',
        259.90,
        'Tênis com amortecimento ideal para corrida.',
        0.9,
        2
    ),
    (
        'Mochila Compacta',
        'Cinza',
        'mochila.jpg',
        129.90,
        'Mochila leve para levar seus itens ao treino.',
        0.6,
        3
    );

INSERT INTO
    variacoes (produto_id, tamanho, estoque)
VALUES
    (1, 'P', 10),
    (1, 'M', 15),
    (1, 'G', 8),
    (2, '38', 5),
    (2, '39', 6),
    (2, '40', 3),
    (3, 'U', 20);

INSERT INTO
    clientes (nome_completo, cpf, data_nascimento)
VALUES
    ('João da Silva', '123.456.789-00', '1990-05-10'),
    ('Maria Oliveira', '987.654.321-00', '1985-08-22');

INSERT INTO
    enderecos (
        cliente_id,
        logradouro,
        cidade,
        bairro,
        numero,
        cep,
        complemento
    )
VALUES
    (
        1,
        'Rua A',
        'Rio de Janeiro',
        'Centro',
        '100',
        '20000-000',
        'Apto 202'
    ),
    (
        2,
        'Av. B',
        'São Paulo',
        'Vila Nova',
        '200',
        '01000-000',
        ''
    );

INSERT INTO
    pedidos (
        cliente_id,
        endereco_entrega_id,
        forma_pagamento,
        valor_frete,
        desconto,
        valor_total,
        data_pedido
    )
VALUES
    (
        1,
        1,
        'PIX',
        10.00,
        11.98,
        117.82,
        '2024-06-05 14:00:00'
    );

INSERT INTO
    itens_pedido (
        pedido_id,
        variacao_id,
        quantidade,
        preco_unitario
    )
VALUES
    (1, 2, 2, 59.90);

UPDATE
    variacoes
SET
    estoque = estoque - 2
WHERE
    id = 2;

INSERT INTO
    funcionarios (nome_completo, cpf, senha_hash, sal)
VALUES
    -- Senha: rodrigues123
    (
        'Paulo Rodrigues',
        '11122233301',
        'c3cc365985a2a24d322f9ddc45b5ff60bc4630bc28c9dd2fce990fc1419b6c3bcb02c1ebef9cb14b793329837586f8d8c5b6d3a1678f75a0402882511bc96197',
        '846dbbae1c0d9b75822989043a4f3837'
    ),

    -- Senha: silva123
    (
        'Ana Silva',
        '22233344402',
        '188b26d6a19e166655cf2c3bc34260475213cdad5d319172a19cffcccc5e8fc8257d28fb66d35c55e5aa757616fc490045226b79fd21846a0206465373213ce5',
        '0c33c2866878ae890b393604952bd154'
    ),
-- Senha: mendes123

    (
        'Carlos Mendes',
        '33344455503',
        '24268fb4c1ce814db602e0c8a1b348ef7b2ce402ffa4b40f4770108b426e2c2dc564e93687c0a7a9baec80120111530b1820def24229228a61995c6ecbca9bbc',
        '227f29611bb371f3ed2e71da537f529f'
    );

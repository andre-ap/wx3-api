USE acme;

-- CATEGORIAS
INSERT INTO categorias (nome, descricao) VALUES
('Roupas', 'Roupas para treino e atividade física'),
('Calçados', 'Tênis e sapatos esportivos'),
('Acessórios', 'Itens complementares como bonés, mochilas, etc');

-- PRODUTOS
INSERT INTO produtos (nome, cor, imagem, preco, descricao, peso, categoria_id)
VALUES
('Camiseta Dry Fit', 'Branca', 'camiseta.jpg', 59.90, 'Camiseta leve e respirável para treino.', 0.25, 1),
('Tênis Corrida Pro', 'Preto', 'tenis.jpg', 299.90, 'Tênis com amortecimento ideal para corrida.', 0.9, 2),
('Mochila Compacta', 'Cinza', 'mochila.jpg', 119.90, 'Mochila leve para levar seus itens ao treino.', 0.6, 3);

-- VARIAÇÕES
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(1, 'P', 10, 59.90),
(1, 'M', 15, 59.90),
(1, 'G', 8, 59.90),
(2, '38', 5, 299.90),
(2, '39', 6, 299.90),
(2, '40', 3, 299.90),
(3, 'U', 20, 119.90);

-- CLIENTES
INSERT INTO clientes (nome_completo, cpf, data_nascimento)
VALUES
('João da Silva', '123.456.789-00', '1990-05-10'),
('Maria Oliveira', '987.654.321-00', '1985-08-22');

-- ENDEREÇOS
INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento)
VALUES
(1, 'Rua A', 'Rio de Janeiro', 'Centro', '100', '20000-000', 'Apto 202'),
(2, 'Av. B', 'São Paulo', 'Vila Nova', '200', '01000-000', '');

-- PEDIDO
INSERT INTO pedidos (cliente_id, endereco_entrega_id, forma_pagamento, valor_frete, desconto, valor_total)
VALUES
(1, 1, 'PIX', 10.00, 11.98, 167.82); -- Exemplo: 2 camisetas a R$59.90 + frete - 10%

-- ITENS DO PEDIDO
INSERT INTO itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario)
VALUES
(1, 2, 2, 59.90); -- 2 camisetas tamanho M

-- Atualizar estoque manualmente após venda (se quiser simular isso)
UPDATE variacoes SET estoque = estoque - 2 WHERE id = 2;

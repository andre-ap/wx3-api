USE acme;

INSERT INTO categorias (nome, descricao) VALUES
('Roupas', 'Roupas para treino e atividade física'),
('Calçados', 'Tênis e sapatos esportivos'),
('Acessórios', 'Itens complementares como bonés, mochilas, etc');

INSERT INTO produtos (nome, cor, imagem, descricao, peso, categoria_id)
VALUES
('Camiseta Dry Fit', 'Branca', 'camiseta.jpg', 'Camiseta leve e respirável para treino.', 0.25, 1),
('Tênis Corrida Pro', 'Preto', 'tenis.jpg', 'Tênis com amortecimento ideal para corrida.', 0.9, 2),
('Mochila Compacta', 'Cinza', 'mochila.jpg', 'Mochila leve para levar seus itens ao treino.', 0.6, 3);

INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(1, 'P', 10, 59.90),
(1, 'M', 15, 59.90),
(1, 'G', 8, 59.90),
(2, '38', 5, 299.90),
(2, '39', 6, 299.90),
(2, '40', 3, 299.90),
(3, 'U', 20, 119.90);

INSERT INTO clientes (nome_completo, cpf, data_nascimento)
VALUES
('João da Silva', '123.456.789-00', '1990-05-10'),
('Maria Oliveira', '987.654.321-00', '1985-08-22');

INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento)
VALUES
(1, 'Rua A', 'Rio de Janeiro', 'Centro', '100', '20000-000', 'Apto 202'),
(2, 'Av. B', 'São Paulo', 'Vila Nova', '200', '01000-000', '');

INSERT INTO pedidos (cliente_id, endereco_entrega_id, forma_pagamento, valor_frete, desconto, valor_total, data_pedido)
VALUES
(1, 1, 'PIX', 10.00, 11.98, 117.82, '2024-06-05 14:00:00');

INSERT INTO itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario)
VALUES
(1, 2, 2, 59.90);

UPDATE variacoes SET estoque = estoque - 2 WHERE id = 2;
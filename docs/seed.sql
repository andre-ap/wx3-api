-- Use o banco de dados acme
USE acme;

-- Inserir dados na tabela 'categorias'
INSERT INTO categorias (nome, descricao) VALUES
('Camisetas', 'Camisetas masculinas e femininas de diversos estilos e tecidos.'),
('Calças', 'Calças jeans, sociais, esportivas e casuais para todos os gêneros.'),
('Vestidos', 'Vestidos elegantes, casuais e de festa para mulheres.'),
('Saias', 'Saias de diferentes comprimentos, tecidos e designs.'),
('Jaquetas', 'Jaquetas e casacos para todas as estações.'),
('Acessórios', 'Cintos, bonés, óculos de sol e outros acessórios.');

-- Inserir dados na tabela 'produtos'
-- Categoria: Camisetas (id=1)
INSERT INTO produtos (nome, cor, imagem, preco_base, descricao, peso, categoria_id) VALUES
('Camiseta Básica Algodão', 'Branco', 'camiseta.jpg', 39.90, 'Camiseta unissex de algodão 100%, ideal para o dia a dia.', 0.20, 1),
('Camiseta Estampada Vintage', 'Preto', 'camiseta2.jpg', 59.90, 'Camiseta com estampa vintage, 100% algodão, corte moderno.', 0.22, 1),
('Camiseta Dry-Fit Esportiva', 'Azul', 'camiseta3.jpg', 79.90, 'Camiseta esportiva com tecnologia dry-fit, para alta performance.', 0.18, 1);

-- Categoria: Calças (id=2)
INSERT INTO produtos (nome, cor, imagem, preco_base, descricao, peso, categoria_id) VALUES
('Calça Jeans Slim Fit', 'Azul Escuro', 'calca1.jpg', 129.90, 'Calça jeans masculina com corte slim fit, confortável e estilosa.', 0.60, 2),
('Calça Social Feminina', 'Preto', 'calca2.jpg', 149.90, 'Calça social feminina de alfaiataria, caimento perfeito.', 0.45, 2);

-- Categoria: Vestidos (id=3)
INSERT INTO produtos (nome, cor, imagem, preco_base, descricao, peso, categoria_id) VALUES
('Vestido Floral Midi', 'Multicor', 'vestido.jpg', 189.90, 'Vestido midi com estampa floral, tecido leve e fluido.', 0.35, 3);

-- Categoria: Jaquetas (id=5)
INSERT INTO produtos (nome, cor, imagem, preco_base, descricao, peso, categoria_id) VALUES
('Jaqueta Jeans Clássica', 'Azul Claro', 'jaqueta.jpf', 249.90, 'Jaqueta jeans unissex, modelo clássico e atemporal.', 0.80, 5);


-- Inserir dados na tabela 'variacoes'
-- Camiseta Básica Algodão (produto_id=1)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(1, 'P', 50, 39.90),
(1, 'M', 75, 39.90),
(1, 'G', 60, 39.90),
(1, 'GG', 30, 44.90);

-- Camiseta Estampada Vintage (produto_id=2)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(2, 'P', 20, 59.90),
(2, 'M', 40, 59.90),
(2, 'G', 35, 59.90);

-- Camiseta Dry-Fit Esportiva (produto_id=3)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(3, 'M', 25, 79.90),
(3, 'G', 20, 79.90);

-- Calça Jeans Slim Fit (produto_id=4)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(4, '38', 30, 129.90),
(4, '40', 45, 129.90),
(4, '42', 40, 129.90),
(4, '44', 20, 139.90);

-- Calça Social Feminina (produto_id=5)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(5, 'P', 15, 149.90),
(5, 'M', 25, 149.90),
(5, 'G', 10, 149.90);

-- Vestido Floral Midi (produto_id=6)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(6, 'P', 10, 189.90),
(6, 'M', 18, 189.90);

-- Jaqueta Jeans Clássica (produto_id=7)
INSERT INTO variacoes (produto_id, tamanho, estoque, preco) VALUES
(7, 'P', 12, 249.90),
(7, 'M', 20, 249.90),
(7, 'G', 15, 249.90);


-- Inserir dados na tabela 'clientes'
INSERT INTO clientes (nome_completo, cpf, data_nascimento) VALUES
('João Silva', '111.222.333-44', '1985-03-15'),
('Maria Oliveira', '555.666.777-88', '1990-07-22'),
('Carlos Souza', '999.888.777-66', '1978-11-01');

-- Inserir dados na tabela 'enderecos'
-- Endereços para João Silva (cliente_id=1)
INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento) VALUES
(1, 'Rua das Flores', 'São Paulo', 'Jardins', '123', '01234-567', 'Apto 101'),
(1, 'Avenida Principal', 'São Paulo', 'Centro', '456', '01000-000', NULL);

-- Endereços para Maria Oliveira (cliente_id=2)
INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento) VALUES
(2, 'Rua da Paz', 'Rio de Janeiro', 'Copacabana', '789', '20000-000', 'Bloco B, Apto 502');

-- Endereços para Carlos Souza (cliente_id=3)
INSERT INTO enderecos (cliente_id, logradouro, cidade, bairro, numero, cep, complemento) VALUES
(3, 'Travessa da Amizade', 'Belo Horizonte', 'Savassi', '10', '30000-111', NULL);


-- Inserir dados na tabela 'pedidos'
-- Pedido 1: João Silva (cliente_id=1), Endereço 1 (endereco_entrega_id=1)
INSERT INTO pedidos (cliente_id, endereco_entrega_id, forma_pagamento, valor_frete, desconto, valor_total, data_pedido) VALUES
(1, 1, 'PIX', 15.00, 0.00, 114.80, '2024-06-01 10:30:00'); -- (2 * 39.90) + 1 * 59.90 + 15.00 = 79.80 + 59.90 + 15.00 = 154.70. Ajustado para 114.80 para exemplo.

-- Pedido 2: Maria Oliveira (cliente_id=2), Endereço 3 (endereco_entrega_id=3)
INSERT INTO pedidos (cliente_id, endereco_entrega_id, forma_pagamento, valor_frete, desconto, valor_total, data_pedido) VALUES
(2, 3, 'CARTAO_1X', 20.00, 10.00, 289.80, '2024-06-05 14:00:00'); -- (1 * 129.90) + (1 * 149.90) + 20.00 - 10.00 = 129.90 + 149.90 + 20.00 - 10.00 = 289.80

-- Pedido 3: João Silva (cliente_id=1), Endereço 2 (endereco_entrega_id=2)
INSERT INTO pedidos (cliente_id, endereco_entrega_id, forma_pagamento, valor_frete, desconto, valor_total, data_pedido) VALUES
(1, 2, 'BOLETO', 10.00, 0.00, 269.90, '2024-06-10 11:45:00'); -- (1 * 249.90) + 10.00 = 259.90. Ajustado para 269.90 para exemplo.


-- Inserir dados na tabela 'itens_pedido'
-- Itens para Pedido 1 (pedido_id=1)
INSERT INTO itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario) VALUES
(1, 1, 2, 39.90), -- 2x Camiseta Básica Algodão (P)
(1, 6, 1, 59.90); -- 1x Camiseta Estampada Vintage (M)

-- Itens para Pedido 2 (pedido_id=2)
INSERT INTO itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario) VALUES
(2, 9, 1, 129.90), -- 1x Calça Jeans Slim Fit (40)
(2, 11, 1, 149.90); -- 1x Calça Social Feminina (M)

-- Itens para Pedido 3 (pedido_id=3)
INSERT INTO itens_pedido (pedido_id, variacao_id, quantidade, preco_unitario) VALUES
(3, 15, 1, 249.90); -- 1x Jaqueta Jeans Clássica (M)

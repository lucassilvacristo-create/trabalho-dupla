CREATE DATABASE IF NOT EXISTS db_pedidos;
USE db_pedidos;

CREATE TABLE usuario (
    id_usuario  INT PRIMARY KEY AUTO_INCREMENT,
    nome        VARCHAR(100) NOT NULL,
    login       VARCHAR(50)  NOT NULL UNIQUE,
    senha       VARCHAR(255) NOT NULL,
    perfil      ENUM('ADMIN', 'GARCOM', 'CAIXA', 'GERENTE') NOT NULL
);

CREATE TABLE mesa (
    id_mesa     INT PRIMARY KEY AUTO_INCREMENT,
    numero      INT NOT NULL,
    status      ENUM('LIVRE', 'OCUPADA', 'RESERVADA') NOT NULL
);

CREATE TABLE cliente (
    id_cliente    INT PRIMARY KEY AUTO_INCREMENT,
    nome          VARCHAR(100) NOT NULL,
    telefone      VARCHAR(20),
    endereco      VARCHAR(150),
    bairro        VARCHAR(80),
    taxa_entrega  INT
);

CREATE TABLE caixa (
    id_caixa         INT PRIMARY KEY AUTO_INCREMENT,
    data_abertura    DATETIME NOT NULL,
    data_fechamento  DATETIME,
    valor_inicial    INT NOT NULL,
    status           ENUM('ABERTO', 'FECHADO') NOT NULL,
    id_usuario       INT NOT NULL,
    CONSTRAINT fk_caixa_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE produto (
    id_produto  INT PRIMARY KEY AUTO_INCREMENT,
    nome        VARCHAR(100) NOT NULL,
    categoria   VARCHAR(60),
    descricao   VARCHAR(100),
    preco       INT NOT NULL,
    ativo       BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE ingrediente (
    id_ingrediente  INT PRIMARY KEY AUTO_INCREMENT,
    nome            VARCHAR(100) NOT NULL,
    estoque_atual   INT NOT NULL DEFAULT 0
);

CREATE TABLE produto_ingrediente (
    id_produto         INT NOT NULL,
    id_ingrediente      INT NOT NULL,
    quantidade_padrao   INT NOT NULL,
    PRIMARY KEY (id_produto, id_ingrediente),
    CONSTRAINT fk_prodingr_produto
        FOREIGN KEY (id_produto) REFERENCES produto(id_produto),
    CONSTRAINT fk_prodingr_ingrediente
        FOREIGN KEY (id_ingrediente) REFERENCES ingrediente(id_ingrediente)
);

CREATE TABLE pedido (
    id_pedido         INT PRIMARY KEY AUTO_INCREMENT,
    origem            ENUM('MESA', 'DELIVERY', 'BALCAO') NOT NULL,
    status            ENUM('ABERTO', 'EM_PREPARO', 'PRONTO', 'ENTREGUE', 'CANCELADO') NOT NULL,
    data_hora         DATETIME NOT NULL,
    valor_total       INT NOT NULL,
    valor_frete       INT DEFAULT 0,
    metodo_pagamento  ENUM('DINHEIRO', 'CARTAO_CREDITO', 'CARTAO_DEBITO', 'PIX') NOT NULL,
    status_pagamento  ENUM('PENDENTE', 'PAGO', 'CANCELADO') NOT NULL,
    idmesa            INT NULL,
    idcliente         INT NULL,
    idusuario         INT NOT NULL,
    idcaixa           INT NULL,
    CONSTRAINT fk_pedido_mesa
        FOREIGN KEY (idmesa) REFERENCES mesa(id_mesa),
    CONSTRAINT fk_pedido_cliente
        FOREIGN KEY (idcliente) REFERENCES cliente(id_cliente),
    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (idusuario) REFERENCES usuario(id_usuario),
    CONSTRAINT fk_pedido_caixa
        FOREIGN KEY (idcaixa) REFERENCES caixa(id_caixa)
);

CREATE TABLE item_pedido (
    id_item_pedido  INT PRIMARY KEY AUTO_INCREMENT,
    idpedido        INT NOT NULL,
    idproduto       INT NOT NULL,
    quantidade      INT NOT NULL,
    preco_unitario  INT NOT NULL,
    observacao      VARCHAR(255),
    CONSTRAINT fk_itempedido_pedido
        FOREIGN KEY (idpedido) REFERENCES pedido(id_pedido),
    CONSTRAINT fk_itempedido_produto
        FOREIGN KEY (idproduto) REFERENCES produto(id_produto)
);

INSERT INTO usuario (nome, login, senha, perfil) VALUES
('Carlos Mendes',    'carlos.admin',   '$2b$10$hashDeExemplo01', 'ADMIN'),
('Fernanda Lima',    'fernanda.ger',   '$2b$10$hashDeExemplo02', 'GERENTE'),
('João Pereira',     'joao.garcom',    '$2b$10$hashDeExemplo03', 'GARCOM'),
('Mariana Souza',    'mariana.garcom', '$2b$10$hashDeExemplo04', 'GARCOM'),
('Ricardo Alves',    'ricardo.caixa',  '$2b$10$hashDeExemplo05', 'CAIXA'),
('Juliana Costa',    'juliana.caixa',  '$2b$10$hashDeExemplo06', 'CAIXA'),
('Pedro Santos',     'pedro.garcom',   '$2b$10$hashDeExemplo07', 'GARCOM');

INSERT INTO mesa (numero, status) VALUES
(1, 'LIVRE'),
(2, 'OCUPADA'),
(3, 'LIVRE'),
(4, 'RESERVADA'),
(5, 'OCUPADA'),
(6, 'LIVRE'),
(7, 'RESERVADA');

INSERT INTO cliente (nome, telefone, endereco, bairro, taxa_entrega) VALUES
('Ana Beatriz Rocha',   '(41) 99911-2233', 'Rua XV de Novembro, 120',      'Centro',        500),
('Bruno Ferreira',      '(41) 99822-3344', 'Av. Sete de Setembro, 2500',   'Batel',         800),
('Camila Duarte',       '(41) 99733-4455', 'Rua Mateus Leme, 455',         'São Francisco', 600),
('Diego Martins',       '(41) 99644-5566', 'Rua Padre Anchieta, 1800',     'Bigorrilho',    900),
('Eduarda Nunes',       '(41) 99555-6677', 'Av. Água Verde, 900',          'Água Verde',    700),
('Felipe Gomes',        '(41) 99466-7788', 'Rua Comendador Araújo, 300',   'Batel',         800),
('Gabriela Teixeira',   '(41) 99377-8899', 'Rua Brigadeiro Franco, 760',   'Centro',        500);

INSERT INTO caixa (data_abertura, data_fechamento, valor_inicial, status, id_usuario) VALUES
('2026-09-28 10:00:00', '2026-09-28 23:00:00', 20000, 'FECHADO', 5),
('2026-09-29 10:00:00', '2026-09-29 23:15:00', 20000, 'FECHADO', 6),
('2026-09-30 10:00:00', '2026-09-30 23:05:00', 25000, 'FECHADO', 5),
('2026-10-01 10:00:00', '2026-10-01 22:50:00', 20000, 'FECHADO', 6),
('2026-10-02 10:00:00', '2026-10-02 23:30:00', 30000, 'FECHADO', 5),
('2026-10-06 10:00:00', '2026-10-06 23:00:00', 20000, 'FECHADO', 6),
('2026-10-07 10:00:00', NULL,                  25000, 'ABERTO',  5);

INSERT INTO produto (nome, categoria, preco, ativo) VALUES
('X-Burger',               'Lanches',     28.00, TRUE),
('X-Bacon',                'Lanches',     34.00, TRUE),
('Pizza Margherita',       'Pizzas',      52.00, TRUE),
('Pizza Calabresa',        'Pizzas',      56.00, TRUE),
('Porção de Batata Frita', 'Porções',     26.00, TRUE),
('Refrigerante Lata',      'Bebidas',      6.00, TRUE),
('Suco de Laranja',        'Bebidas',      9.00, TRUE),
('Pudim de Leite',         'Sobremesas',  12.00, FALSE);

INSERT INTO ingrediente (nome, estoque_atual) VALUES
('Pão de hambúrguer',          120),
('Carne bovina (hambúrguer)',  100),
('Queijo mussarela (fatia)',   500),
('Bacon (fatia)',              300),
('Massa de pizza',              60),
('Molho de tomate (ml)',      8000),
('Calabresa (fatia)',          400),
('Batata (g)',               15000),
('Laranja',                     80);

INSERT INTO produto_ingrediente (id_produto, id_ingrediente, quantidade_padrao) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 2),
(2, 1, 1),
(2, 2, 1),
(2, 3, 2),
(2, 4, 3),
(3, 5, 1),
(3, 6, 150),
(3, 3, 8),
(4, 5, 1),
(4, 6, 150),
(4, 3, 6),
(4, 7, 12),
(5, 8, 400),
(7, 9, 3);

INSERT INTO pedido
(origem, status, data_hora, valor_total, valor_frete, metodo_pagamento, status_pagamento, idmesa, idcliente, idusuario, idcaixa) VALUES
('MESA',     'ENTREGUE',   '2026-09-28 12:30:00',  6800,   0, 'CARTAO_CREDITO', 'PAGO',      2,    NULL, 3, 1),
('DELIVERY', 'ENTREGUE',   '2026-09-29 19:45:00',  6300, 500, 'PIX',            'PAGO',      NULL, 1,    5, 2),
('BALCAO',   'ENTREGUE',   '2026-09-30 13:10:00',  4300,   0, 'DINHEIRO',       'PAGO',      NULL, NULL, 5, 3),
('MESA',     'ENTREGUE',   '2026-10-01 20:15:00', 10000,   0, 'CARTAO_DEBITO',  'PAGO',      5,    NULL, 4, 4),
('DELIVERY', 'ENTREGUE',   '2026-10-02 21:00:00', 10200, 800, 'PIX',            'PAGO',      NULL, 2,    6, 5),
('DELIVERY', 'CANCELADO',  '2026-10-06 19:30:00',  6700, 600, 'CARTAO_CREDITO', 'CANCELADO', NULL, 3,    6, 6),
('MESA',     'EM_PREPARO', '2026-10-07 12:20:00', 10000,   0, 'DINHEIRO',       'PENDENTE',  2,    NULL, 7, 7);

INSERT INTO item_pedido (idpedido, idproduto, quantidade, preco_unitario, observacao) VALUES
(1, 1, 2, 2800, 'Um sem cebola'),
(1, 6, 2,  600, NULL),
(2, 3, 1, 5200, 'Sem orégano'),
(2, 6, 1,  600, NULL),
(3, 2, 1, 3400, 'Bem passado'),
(3, 7, 1,  900, 'Sem açúcar'),
(4, 4, 1, 5600, NULL),
(4, 5, 1, 2600, 'Bastante sal'),
(4, 6, 3,  600, NULL),
(5, 2, 2, 3400, 'Maionese à parte'),
(5, 5, 1, 2600, NULL),
(6, 3, 1, 5200, NULL),
(6, 7, 1,  900, NULL),
(7, 1, 2, 2800, 'Ponto da carne: médio'),
(7, 5, 1, 2600, NULL),
(7, 7, 2,  900, 'Com gelo');

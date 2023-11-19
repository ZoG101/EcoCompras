-- Active: 1699823662542@@127.0.0.1@3307
CREATE DATABASE Eco_Compras
    DEFAULT CHARACTER SET = 'utf8mb4';

USE Eco_Compras;

drop table ENDERECO;
drop table CLIENTE;
drop table PEDIDO;
drop table ITEM_PEDIDO;

SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE `CLIENTE` (
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(12) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(12) NOT NULL,
    PRIMARY KEY (email) 
);

CREATE TABLE `ENDERECO` (
    cep VARCHAR(8) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    estado VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    complemento VARCHAR(255) NOT NULL,
    cliente_email VARCHAR(255) NOT NULL,
    PRIMARY KEY (cep, rua, numero, cliente_email),
    Foreign Key (cliente_email) REFERENCES CLIENTE (email)
);

CREATE TABLE `PEDIDO` (
    id INT(10) ZEROFILL PRIMARY KEY AUTO_INCREMENT,
    valor_total FLOAT NOT NULL,
    data DATETIME NOT NULL,
    estado boolean NOT NULL DEFAULT 0,
    cliente_email VARCHAR(255) NOT NULL,
    Foreign Key (cliente_email) REFERENCES CLIENTE (email)
);

CREATE TABLE `ITEM_PEDIDO` (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nome_produto VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario FLOAT NOT NULL,
    pedido_id INT(10) ZEROFILL NOT NULL,
    Foreign Key (pedido_id) REFERENCES PEDIDO (id)
);

INSERT INTO cliente VALUES('ecompras', '11111111111', 'eco@gmail.com', 'eco2023', '11111111111');
INSERT INTO endereco (cep, cidade, estado, rua, numero, bairro, complemento, cliente_email) VALUES('00000000', 'nowhere', 'nowhere', 'nowhere', 'nowhere', 'nowhere', 'nowhere', 'eco@gmail.com');

INSERT INTO pedido (valor_total, data, estado, cliente_email) VALUES(100.0, '2021-08-04 14:00:00', 0, 'teste12@gmail.com');

INSERT INTO item_pedido (nome_produto, quantidade, valor_unitario, pedido_id) VALUES('mochila', 1, 100, 0000000008);

SELECT endereco.cep, endereco.cidade, endereco.estado, endereco.rua, endereco.numero, endereco.bairro, endereco.complemento FROM cliente JOIN endereco ON endereco.cliente_email = "teste3@gmail.com";

SELECT COUNT(*) FROM cliente JOIN endereco ON endereco.cliente_email = :email;

select * from item_pedido;

select * from cliente;

select * from endereco;

SELECT * FROM cliente WHERE email = :email;

SELECT * FROM pedido;

SELECT id FROM pedido WHERE cliente_email = :email ORDER BY id DESC LIMIT 1;

SELECT * FROM PEDIDO WHERE PEDIDO.cliente_email = :email;

SELECT PEDIDO.id, ITEM_PEDIDO.nome_produto, ITEM_PEDIDO.quantidade, ITEM_PEDIDO.valor_unitario FROM PEDIDO JOIN ITEM_PEDIDO ON PEDIDO.id = ITEM_PEDIDO.pedido_id AND PEDIDO.cliente_email = :email;

UPDATE pedido SET estado = 1;

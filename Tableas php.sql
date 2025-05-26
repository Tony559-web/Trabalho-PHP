CREATE DATABASE loja_seguros;

USE loja_seguros;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'cliente') NOT NULL
);

CREATE TABLE carros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    ano YEAR NOT NULL,
    preco_diaria DECIMAL(10, 2) NOT NULL,
    disponivel BOOLEAN DEFAULT TRUE
);

CREATE TABLE seguros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carro_id INT,
    tipo_seguro VARCHAR(100) NOT NULL,
    cobertura VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (carro_id) REFERENCES carros(id)
);

CREATE TABLE alugueis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    carro_id INT,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    status ENUM('ativo', 'finalizado') DEFAULT 'ativo',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (carro_id) REFERENCES carros(id)
);

CREATE TABLE relatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_geracao DATETIME NOT NULL,
    tipo_relatorio VARCHAR(100) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluguel_id INT,
    valor_pago DECIMAL(10, 2) NOT NULL,
    data_pagamento DATETIME NOT NULL,
    FOREIGN KEY (aluguel_id) REFERENCES alugueis(id)
);
-- Criação do banco de dados ITSM
DROP DATABASE IF EXISTS ITSM;
CREATE DATABASE ITSM;
USE ITSM;

-- Criação da tabela de usuários com campo função
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    funcao VARCHAR(50),
    ativo BOOLEAN NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Criação da tabela de status
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

-- Criação da tabela de incidentes
CREATE TABLE incidentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) UNIQUE,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    status INT NOT NULL,
    prioridade VARCHAR(30) NOT NULL,
    atribuido_para INT DEFAULT NULL,
    criado_por INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (status) REFERENCES status(id),
    FOREIGN KEY (criado_por) REFERENCES usuarios(id),
    FOREIGN KEY (atribuido_para) REFERENCES usuarios(id)
);

-- Criação da tabela de requisições
CREATE TABLE requisicoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) UNIQUE,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    tipo VARCHAR(30) NOT NULL,
    atribuido_para INT DEFAULT NULL,
    status INT NOT NULL,
    criado_por INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (status) REFERENCES status(id),
    FOREIGN KEY (criado_por) REFERENCES usuarios(id),
    FOREIGN KEY (atribuido_para) REFERENCES usuarios(id)
);

-- Triggers para gerar código formatado
DELIMITER //

CREATE TRIGGER trg_incidentes_codigo
BEFORE INSERT ON incidentes
FOR EACH ROW
BEGIN
    DECLARE novo_codigo VARCHAR(10);
    DECLARE ultimo_id INT;

    IF NEW.codigo IS NULL THEN
        SELECT IFNULL(MAX(id), 0) + 1 INTO ultimo_id FROM incidentes;
        SET novo_codigo = CONCAT('INC', LPAD(ultimo_id, 4, '0'));
        SET NEW.codigo = novo_codigo;
    END IF;
END;
//

CREATE TRIGGER trg_requisicoes_codigo
BEFORE INSERT ON requisicoes
FOR EACH ROW
BEGIN
    DECLARE novo_codigo VARCHAR(10);
    DECLARE ultimo_id INT;

    IF NEW.codigo IS NULL THEN
        SELECT IFNULL(MAX(id), 0) + 1 INTO ultimo_id FROM requisicoes;
        SET novo_codigo = CONCAT('REQ', LPAD(ultimo_id, 4, '0'));
        SET NEW.codigo = novo_codigo;
    END IF;
END;
//
DELIMITER ;

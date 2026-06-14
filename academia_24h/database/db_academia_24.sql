CREATE DATABASE IF NOT EXISTS db_academia_24;
USE db_academia_24;

-- Tabela padrão de Usuários/Administradores do sistema (Requisito da Etapa 2)
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- CRUD 1: Equipamentos / Estrutura de Treino
CREATE TABLE IF NOT EXISTS equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    estado_conservacao VARCHAR(50) NOT NULL
);

-- CRUD 2: Planos de Treinamento / Bolsas de Desempenho
CREATE TABLE IF NOT EXISTS planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    valor DECIMAL(10,2) NOT NULL
);

-- CRUD 3: Serviços / Modalidades Esportivas Ofertadas
CREATE TABLE IF NOT EXISTS servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_servico VARCHAR(100) NOT NULL,
    categoria_esporte VARCHAR(50) NOT NULL,
    professor_responsavel VARCHAR(100) NOT NULL
);

-- Inserir usuário padrão exigido pelo professor para testes
-- Login: admin | Senha: 123 (criptografada em MD5 ou texto plano, vamos usar MD5 para segurança básica)
INSERT INTO usuario (nome, telefone, email, login, senha) 
VALUES ('Administrador', '49999999999', 'admin@academia.com', 'admin', MD5('123'))
ON DUPLICATE KEY UPDATE login=login;
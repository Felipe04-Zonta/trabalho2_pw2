-- Cria o banco de dados caso ele não exista e define o padrão de acentuação para a língua portuguesa (utf8)
CREATE DATABASE IF NOT EXISTS db_academia_24 CHARACTER SET utf8 COLLATE utf8_general_ci;
USE db_academia_24;

-- Tabela de Utilizadores (Administradores e Atletas)
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único gerado automaticamente
    nome VARCHAR(100) NOT NULL,        -- Nome completo do utilizador
    telefone VARCHAR(20) NOT NULL,     -- Contacto telefónico
    email VARCHAR(100) NOT NULL,       -- Endereço de e-mail para contacto
    login VARCHAR(50) NOT NULL UNIQUE, -- Nome de utilizador único para login (não podem existir dois iguais)
    senha VARCHAR(255) NOT NULL        -- Senha armazenada de forma segura
);

-- Tabela de Equipamentos (Módulo Infraestrutura)
CREATE TABLE IF NOT EXISTS equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    estado_conservacao VARCHAR(50) NOT NULL -- Guarda se está 'Novo', 'Bom' ou em 'Manutenção'
);

-- Tabela de Planos de Treinamento e Bolsas de Incentivo
CREATE TABLE IF NOT EXISTS planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,                -- Campo de texto longo para a descrição das vantagens do plano
    valor DECIMAL(10,2) NOT NULL           -- Guarda valores monetários com duas casas decimais (Ex: 350.00)
);

-- Tabela de Serviços (Modalidades Desportivas Ofertadas)
CREATE TABLE IF NOT EXISTS servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_servico VARCHAR(100) NOT NULL,
    categoria_esporte VARCHAR(50) NOT NULL,
    professor_responsavel VARCHAR(100) NOT NULL
);

-- Insere um administrador padrão caso não exista. A função MD5('123') gera a hash criptográfica da senha.
INSERT INTO usuario (nome, telefone, email, login, senha) VALUES 
('Jackson Meires', '49988005500', 'jackson.meires@ifsc.edu.br', 'admin', MD5('123')) 
ON DUPLICATE KEY UPDATE login=login;

-- Insere registos de teste para demonstrar o funcionamento dos filtros de pesquisa
INSERT INTO equipamentos (nome, quantidade, estado_conservacao) VALUES ('Esteira Ergométrica Matrix Pro', 6, 'Novo');
INSERT INTO planos (nome_plano, descricao, valor) VALUES ('Plano Alto Rendimento', 'Suporte integral técnico e nutricional.', 350.00);
INSERT INTO servicos (nome_servico, categoria_esporte, professor_responsavel) VALUES ('Preparação de Velocidade e Sprint', 'Atletismo', 'Prof. Roberto Alencar');
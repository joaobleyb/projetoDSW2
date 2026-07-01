CREATE DATABASE IF NOT EXISTS desen_web;
USE desen_web;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genero VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS filmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    diretor VARCHAR(255) NOT NULL,
    genero_id INT NOT NULL,
    duracao INT NOT NULL,
    ano_lancamento YEAR NOT NULL,
    plataforma ENUM('streaming', 'cinemas', 'ambos') NOT NULL,
    FOREIGN KEY (genero_id) REFERENCES generos(id)
);

INSERT INTO usuarios (nome, email, senha) VALUES (
    'João Silva',
    'joao@email.com',
    '$2y$10$icz5PygnyC586KcnztTvFuiIDoSgAJKJaScmyEsDbRcQ1ofoaFhOy'
);

INSERT INTO generos (genero) VALUES
    ('Ação'),
    ('Comédia'),
    ('Drama'),
    ('Terror'),
    ('Ficção Científica');

INSERT INTO filmes (titulo, diretor, genero_id, duracao, ano_lancamento, plataforma) VALUES
    ('Inception', 'Christopher Nolan', 5, 148, 2010, 'streaming'),
    ('The Dark Knight', 'Christopher Nolan', 1, 152, 2008, 'ambos'),
    ('Interestelar', 'Christopher Nolan', 5, 169, 2014, 'cinemas');

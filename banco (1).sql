-- ========================================
-- Projeto Livraria - Banco de Dados
-- ========================================

CREATE DATABASE IF NOT EXISTS livraria;
USE livraria;

CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(120) NOT NULL,
    editora VARCHAR(120),
    ano_publicacao INT,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados de exemplo
INSERT INTO livros (titulo, autor, editora, ano_publicacao, preco, quantidade) VALUES
('Dom Casmurro', 'Machado de Assis', 'Editora Ática', 1899, 29.90, 10),
('O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Agir', 1943, 24.50, 15),
('1984', 'George Orwell', 'Companhia das Letras', 1949, 39.90, 8);

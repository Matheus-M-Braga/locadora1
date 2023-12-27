CREATE DATABASE IF NOT EXISTS `locadorabd`;

USE `locadorabd`;

-- Usuários
CREATE TABLE `usuarios` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(45) NOT NULL,
    `cidade` varchar(45) NOT NULL,
    `endereco` varchar(75) NOT NULL,
    `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    PRIMARY KEY (`id`)
);

-- Editoras
CREATE TABLE `editoras` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(45) NOT NULL,
    `cidade` varchar(45) NOT NULL,
    `email` varchar(45) NOT NULL,
    PRIMARY KEY (`id`)
);

-- Livros 
CREATE TABLE `livros` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(45) NOT NULL,
    `autor` varchar(45) NOT NULL,
    `editora_id` int(11) NOT NULL,
    `lancamento` int(4) NOT NULL,
    `quantidade` int(4) NOT NULL,
    `alugados` int(4) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`editora_id`) REFERENCES editoras(id)
);


-- Aluguéis
CREATE TABLE `alugueis` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `livro_id` int(11) NOT NULL,
    `usuario_id` int(11) NOT NULL,
    `data_aluguel` DATE NOT NULL,
    `prev_devolucao` DATE NOT NULL,
    `data_devolucao` DATE NULL,
    `status` varchar(45) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`livro_id`) REFERENCES livros(id),
    FOREIGN KEY (`usuario_id`) REFERENCES usuarios(id)
);

-- Os adm
CREATE TABLE `gerenciadores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario` varchar(75) NOT NULL,
    `senha` varchar(35) NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `gerenciadores`
VALUES (1, 'admin', 'senha123'), (2, 'manager', 'senha456'), (3, 'supervisor', 'senha789'), (4, 'root', 'senhaabc'), (5, 'developer', 'senhafoda');




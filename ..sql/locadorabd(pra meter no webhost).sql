-- **Recomendável só copiar e colar esse código na aba SQL do PHPMyadmin e executar.**
CREATE DATABASE IF NOT EXISTS `id20793781_locadorabd`;
USE `id20793781_locadorabd`;

DROP TABLE IF EXISTS `alugueis`;
CREATE TABLE `alugueis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `data_aluguel` varchar(45) NOT NULL,
  `prev_devolucao` varchar(45) NOT NULL,
  `data_devolucao` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `alugueis` WRITE;
INSERT INTO `alugueis` VALUES (1,'O Senhor dos Anéis','Ricardo','2023-09-06','2023-10-06','2023-09-06','No prazo'),(2,'O Senhor dos Anéis','Pedro','2023-09-06','2023-10-01','0','Pendente'),(3,'Memórias Póstumas de Brás Cubas','Matheus','2023-09-06','2023-09-08','0','Pendente'),(4,'O Senhor dos Anéis','Marina','2023-09-06','2023-09-09','0','Pendente'),(5,'A Metamorfose','Josias','2023-09-06','2023-09-21','0','Pendente'),(6,'O Senhor dos Anéis','Ricardo','2023-09-06','2023-09-23','0','Pendente'),(7,'Memórias Póstumas de Brás Cubas','Ester','2023-09-06','2023-09-16','0','Pendente'),(8,'Dom Casmurro','Frnaiaf','2023-09-14','2023-09-29','0','Pendente');
UNLOCK TABLES;

DROP TABLE IF EXISTS `editoras`;
CREATE TABLE `editoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `editoras` WRITE;
INSERT INTO `editoras` VALUES 
(1, 'Companhia das Letras', 'contato@companhiadasletras.com', '(11) 3376-8965'),
(2, 'Editora Globo', 'contato@editoraglobo.com', '(51) 3355-1234'),
(3, 'Editora Intrínseca', 'contato@editoraintrinseca.com', '(21) 9876-5432'),
(4, 'Editora Record', 'contato@editorarecord.com', '(11) 5555-4321'),
(5, 'Editora Sextante', 'contato@editorasextante.com', '(31) 2345-6789');
UNLOCK TABLES;

DROP TABLE IF EXISTS `gerenciadores`;
CREATE TABLE `gerenciadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(75) NOT NULL,
  `senha` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `gerenciadores` WRITE;
INSERT INTO `gerenciadores` VALUES 
(1, 'admin', 'senha123'),
(2, 'manager', 'senha456'),
(3, 'supervisor', 'senha789'),
(4, 'root', 'senhaabc'),
(5, 'developer', 'senhamaster');
UNLOCK TABLES;

DROP TABLE IF EXISTS `livros`;
CREATE TABLE `livros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `autor` varchar(45) NOT NULL,
  `editora` varchar(45) NOT NULL,
  `lancamento` int(4) NOT NULL,
  `quantidade` int(4) NOT NULL,
  `alugados` int(4) NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `livros` WRITE;
INSERT INTO `livros` VALUES 
(1, 'O Senhor dos Anéis', 'J.R.R. Tolkien', 'Companhia das Letras', 1954, 50, 10),
(2, 'Dom Casmurro', 'Machado de Assis', 'Editora Globo', 1899, 30, 5),
(3, 'Crime e Castigo', 'Fiódor Dostoiévski', 'Editora Intrínseca', 1866, 25, 3),
(4, '1984', 'George Orwell', 'Companhia das Letras', 1949, 40, 8),
(5, 'A Revolução dos Bichos', 'George Orwell', 'Companhia das Letras', 1945, 35, 7),
(6, 'Cem Anos de Solidão', 'Gabriel García Márquez', 'Companhia das Letras', 1967, 28, 6),
(7, 'Memórias Póstumas de Brás Cubas', 'Machado de Assis', 'Editora Globo', 1881, 32, 4),
(8, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Companhia das Letras', 1943, 45, 9),
(9, 'Orgulho e Preconceito', 'Jane Austen', 'Editora Globo', 1813, 27, 5),
(10, 'A Metamorfose', 'Franz Kafka', 'Editora Intrínseca', 1915, 23, 4);
UNLOCK TABLES;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `endereco` varchar(75) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
);

LOCK TABLES `usuarios` WRITE;
INSERT INTO `usuarios` (id, nome, cidade, endereco, email) VALUES
(1, 'Matheus', 'Fortaleza - CE', 'Av. Pasteur, 1234', 'matheus@gmail.com'),
(2, 'Ester', 'Belo Horizonte - MG', 'Palmeiras Vermelhas, 123', 'ester@gmail.com'),
(3, 'Josias', 'Rolândia - PR', 'Rua das Árvores, 123', 'josias@wda.com.br'),
(4, 'Ricardo', 'Crato - CE', 'Rua Principal, 456', 'ricardo@gmail.com'),
(5, 'Maria', 'São Paulo - SP', 'Av. Paulista, 789', 'maria@gmail.com'),
(6, 'João', 'Fortaleza - CE', 'Av. Pasteur, 567', 'joao@gmail.com'),
(7, 'Isabela', 'Recife - PE', 'Rua das Flores, 567', 'isabela@gmail.com'),
(8, 'Lucas', 'São Paulo - SP', 'Av. Paulista, 789', 'lucas@gmail.com'),
(9, 'Marina', 'Porto Alegre - RS', 'Rua Porto, 456', 'marina@gmail.com'),
(10, 'Felipe', 'Salvador - BA', 'Av. da Praia, 789', 'felipe@gmail.com'),
(11, 'Gabriela', 'Curitiba - PR', 'Rua Curitiba, 123', 'gabriela@gmail.com'),
(12, 'Rafael', 'Brasília - DF', 'Av. Brasília, 456', 'rafael@gmail.com'),
(13, 'Ana', 'Fortaleza - CE', 'Av. Castelo, 789', 'ana@gmail.com'),
(14, 'Pedro', 'Belo Horizonte - MG', 'Rua Palmeiras, 456', 'pedro@gmail.com'),
(15, 'Carolina', 'Rio de Janeiro - RJ', 'Av. Copacabana, 123', 'carolina@gmail.com');
UNLOCK TABLES;


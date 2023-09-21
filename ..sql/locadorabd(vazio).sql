USE `locadorabd_fk_test`;

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

DROP TABLE IF EXISTS `editoras`;
CREATE TABLE `editoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `gerenciadores`;
CREATE TABLE `gerenciadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(75) NOT NULL,
  `senha` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
);

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

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `endereco` varchar(75) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
);


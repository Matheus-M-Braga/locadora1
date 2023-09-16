CREATE DATABASE  IF NOT EXISTS `locadorabd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `locadorabd`;
-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: locadorabd
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alugueis`
--

DROP TABLE IF EXISTS `alugueis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alugueis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `data_aluguel` varchar(45) NOT NULL,
  `prev_devolucao` varchar(45) NOT NULL,
  `data_devolucao` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alugueis`
--

LOCK TABLES `alugueis` WRITE;
/*!40000 ALTER TABLE `alugueis` DISABLE KEYS */;
INSERT INTO `alugueis` VALUES (1,'O Senhor dos Anéis','Ricardo','2023-09-06','2023-10-06','2023-09-06','No prazo'),(2,'O Senhor dos Anéis','Pedro','2023-09-06','2023-10-01','0','Pendente'),(3,'Memórias Póstumas de Brás Cubas','Matheus','2023-09-06','2023-09-08','0','Pendente'),(4,'O Senhor dos Anéis','Marina','2023-09-06','2023-09-09','0','Pendente'),(5,'A Metamorfose','Josias','2023-09-06','2023-09-21','0','Pendente'),(6,'O Senhor dos Anéis','Ricardo','2023-09-06','2023-09-23','0','Pendente'),(7,'Memórias Póstumas de Brás Cubas','Ester','2023-09-06','2023-09-16','0','Pendente'),(8,'Dom Casmurro','Frnaiaf','2023-09-14','2023-09-29','0','Pendente');
/*!40000 ALTER TABLE `alugueis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editoras`
--

DROP TABLE IF EXISTS `editoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editoras`
--

LOCK TABLES `editoras` WRITE;
/*!40000 ALTER TABLE `editoras` DISABLE KEYS */;
INSERT INTO `editoras` VALUES (1,'Companhia das Letras','contato@companhiadasletras.com','(11) 3376-8965'),(2,'Editora Globo','contato@editoraglobo.com','(51) 3355-1234'),(3,'Editora Intrínseca','contato@editoraintrinseca.com','(21) 9876-5432'),(4,'Editora Record','contato@editorarecord.com','(11) 5555-4321'),(5,'Editora Sextante','contato@editorasextante.com','(31) 2345-6789');
/*!40000 ALTER TABLE `editoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gerenciadores`
--

DROP TABLE IF EXISTS `gerenciadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gerenciadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(75) NOT NULL,
  `senha` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gerenciadores`
--

LOCK TABLES `gerenciadores` WRITE;
/*!40000 ALTER TABLE `gerenciadores` DISABLE KEYS */;
INSERT INTO `gerenciadores` VALUES (1,'admin','senha123'),(2,'manager','senha456'),(3,'supervisor','senha789'),(4,'root','senhaabc'),(5,'developer','senhamas');
/*!40000 ALTER TABLE `gerenciadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livros`
--

DROP TABLE IF EXISTS `livros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `autor` varchar(45) NOT NULL,
  `editora` varchar(45) NOT NULL,
  `lancamento` int(4) NOT NULL,
  `quantidade` int(4) NOT NULL,
  `alugados` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livros`
--

LOCK TABLES `livros` WRITE;
/*!40000 ALTER TABLE `livros` DISABLE KEYS */;
INSERT INTO `livros` VALUES (1,'O Senhor dos Anéis','J.R.R. Tolkien','Companhia das Letras',1954,46,3),(2,'Dom Casmurro','Machado de Assis','Editora Globo',1899,29,1),(3,'Crime e Castigo','Fiódor Dostoiévski','Editora Intrínseca',1866,25,0),(4,'1984','George Orwell','Companhia das Letras',1949,40,0),(5,'A Revolução dos Bichos','George Orwell','Companhia das Letras',1945,35,0),(6,'Cem Anos de Solidão','Gabriel García Márquez','Companhia das Letras',1967,28,0),(7,'Memórias Póstumas de Brás Cubas','Machado de Assis','Editora Globo',1881,30,2),(8,'O Pequeno Príncipe','Antoine de Saint-Exupéry','Companhia das Letras',1943,45,0),(9,'Orgulho e Preconceito','Jane Austen','Editora Globo',1813,27,0),(10,'A Metamorfose','Franz Kafka','Editora Intrínseca',1915,22,1);
/*!40000 ALTER TABLE `livros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `endereco` varchar(75) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (3,'Josias','Rolândia - PR','Rua das Árvores, 123','josias@wda.com.br'),(5,'Maria','São Paulo - SP','Av. Paulista, 789','maria@gmail.com'),(6,'João','Fortaleza - CE','Av. Pasteur, 567','buceta'),(7,'Isabela','Recife - PE','Rua das Flores, 567','isabela@gmail.com'),(8,'Lucas','São Paulo - SP','Av. Paulista, 789','lucas@gmail.com'),(9,'Marina','Porto Alegre - RS','Rua Porto, 456','marina@gmail.com'),(10,'Felipe','Salvador - BA','Av. da Praia, 789','felipe@gmail.com'),(11,'Gabriela','Curitiba - PR','Rua Curitiba, 123','gabriela@gmail.com'),(12,'Rafael','Brasília - DF','Av. Brasília, 456','rafael@gmail.com'),(13,'Ana','Fortaleza - CE','Av. Castelo, 789','ana@gmail.com'),(14,'Pedro','Belo Horizonte - MG','Rua Palmeiras, 456','pedro@gmail.com'),(15,'Carolinazona','Rio de Janeiro - RJ','Av. Copacabana, 123','carolina@gmail.com'),(16,'Frnaiaf','SIM','oi','fadf@afmfk.cm');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-15 19:24:08

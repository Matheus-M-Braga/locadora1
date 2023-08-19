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
  `CodAluguel` int(11) NOT NULL AUTO_INCREMENT,
  `livro` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `data_aluguel` varchar(45) NOT NULL,
  `prev_devolucao` varchar(45) NOT NULL,
  `data_devolucao` varchar(45) NOT NULL,
  PRIMARY KEY (`CodAluguel`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alugueis`
--

LOCK TABLES `alugueis` WRITE;
/*!40000 ALTER TABLE `alugueis` DISABLE KEYS */;
INSERT INTO `alugueis` VALUES (3,'Guerra e Paz','Júlia','2023-05-01','2023-05-22','18/08/2023'),(6,'Demon Slayer','Carlos','2023-05-09','2023-05-22','19/08/2023'),(7,'Guerra e Paz','Ester','2023-05-03','2023-05-08','0'),(9,'Guerra e Paz','Matheus','2023-08-18','2023-08-30','0'),(10,'Demon Slayer','Ester','2023-08-19','2023-08-29','0'),(11,'Hellraiser','Matheus','2023-08-19','2023-08-31','0'),(12,'Livrozin','Carlos','2023-08-19','2023-08-30','19/08/2023');
/*!40000 ALTER TABLE `alugueis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editoras`
--

DROP TABLE IF EXISTS `editoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editoras` (
  `CodEditora` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `website` varchar(45) NOT NULL,
  PRIMARY KEY (`CodEditora`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editoras`
--

LOCK TABLES `editoras` WRITE;
/*!40000 ALTER TABLE `editoras` DISABLE KEYS */;
INSERT INTO `editoras` VALUES (1,'Companhia das Letras','companhia@livrobingo.com.br','1133768965','https://www.companhiadasletras.com.br'),(2,'Panini','panini@contato.com','6789911432','panini.com.br'),(3,'Darkside','darkside@gmail.com','6789123443',''),(4,'TechnoLords','technolordsviera@gmail.com','85 986052523','technolords.com.br');
/*!40000 ALTER TABLE `editoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gerenciadores`
--

DROP TABLE IF EXISTS `gerenciadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gerenciadores` (
  `CodGerente` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(75) NOT NULL,
  `senha` varchar(8) NOT NULL,
  PRIMARY KEY (`CodGerente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gerenciadores`
--

LOCK TABLES `gerenciadores` WRITE;
/*!40000 ALTER TABLE `gerenciadores` DISABLE KEYS */;
INSERT INTO `gerenciadores` VALUES (1,'medeiros','1234');
/*!40000 ALTER TABLE `gerenciadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livros`
--

DROP TABLE IF EXISTS `livros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livros` (
  `CodLivro` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `autor` varchar(45) NOT NULL,
  `editora` varchar(45) NOT NULL,
  `lancamento` varchar(45) NOT NULL,
  `quantidade` int(45) NOT NULL,
  `alugados` int(45) NOT NULL,
  PRIMARY KEY (`CodLivro`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livros`
--

LOCK TABLES `livros` WRITE;
/*!40000 ALTER TABLE `livros` DISABLE KEYS */;
INSERT INTO `livros` VALUES (1,'Demon Slayer','Koyoharu Gotōge','Companhia das Letras','2017-05-10',33,1),(2,'Guerra e Paz','Liev Tolstói','Companhia das Letras','2017-11-21',12,2),(3,'Hellraiser','Clive Barker','Darkside','1986-11-12',24,1),(6,'Livrozin','Autorzin','Panini','2006-03-12',32,0),(7,'asdasd','asdasd','Darkside','2023-08-19',123,0),(8,'saaaaa','adadsa','Panini','2023-08-19',123,0),(9,'porra','meu pau','Darkside','2023-08-29',12,0),(10,'Novo','meu pau','Darkside','2023-08-31',12,0),(11,'Teste','caralho','Panini','2023-08-23',15,0),(12,'Meu ovo','grande','Darkside','2023-08-30',15,0),(13,'adsadas','asdadas','Companhia das Letras','2023-08-21',1563,0),(14,'testando','dfjaisoklf','Panini','2023-08-29',15,0),(15,'esgotado','esgoto','TechnoLords','2023-08-30',0,0);
/*!40000 ALTER TABLE `livros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `CodUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(45) NOT NULL,
  `Cidade` varchar(45) NOT NULL,
  `Endereco` varchar(75) NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`CodUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'Matheus','Fortaleza - CE','Av. Pasteur, 1234','matheus@gmail.com'),(3,'Ester','Belo Horizonte - MG','Palmeiras Vermelhas, 123','ester@gmail.com'),(4,'Josias','Rolandia','logo ali','josias@wda.com.br');
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

-- Dump completed on 2023-08-19 20:14:59

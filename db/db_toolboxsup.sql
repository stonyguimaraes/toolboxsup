CREATE DATABASE  IF NOT EXISTS `db_toolboxsup` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_toolboxsup`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: suporte_ileva
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chamados`
--

DROP TABLE IF EXISTS `chamados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chamados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `assunto` varchar(255) NOT NULL,
  `tipo` enum('Suporte','Reunião Tira Dúvida','Treinamento','Reunião Externa') NOT NULL,
  `situacao` enum('Aberto','Andamento','Concluído') NOT NULL DEFAULT 'Aberto',
  `data_inicial` date NOT NULL,
  `hora_inicial` time NOT NULL,
  `data_final` date DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `fk_usuario` (`usuario_id`),
  CONSTRAINT `chamados_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chamados`
--

LOCK TABLES `chamados` WRITE;
/*!40000 ALTER TABLE `chamados` DISABLE KEYS */;
INSERT INTO `chamados` VALUES (1,2,'','Suporte','Aberto','2025-09-05','22:46:00','2025-09-05','00:46:00','Atendimento realizado via whatsapp','2025-09-06 01:46:46',1),(2,1,'Gerar pdf e descrição','Suporte','Andamento','2025-09-05','22:48:00','0000-00-00','00:00:00','Gerar pdf e descrição','2025-09-06 01:48:31',1),(7,3,'Gestão Inicial','Treinamento','Aberto','2025-09-14','00:43:00','0000-00-00','00:00:00','','2025-09-06 03:47:58',1),(8,1,'','Reunião Tira Dúvida','Aberto','2025-09-15','02:50:00','0000-00-00','00:00:00','eeee','2025-09-06 03:48:21',2),(9,2,'Alteração de foto na vistoria','Suporte','Aberto','2025-09-07','01:06:00','0000-00-00','00:00:00','','2025-09-06 04:06:56',1),(10,3,'Alteração de Termo','Suporte','Aberto','2025-09-06','17:12:00','2025-09-06','00:00:00','Cliente solicitou alterar os campos e imagens do termo, ele mandou o modelo via whatsapp','2025-09-06 20:15:32',1),(11,2,'Gestão Faturamento','Treinamento','Aberto','2025-09-06','18:28:00','2025-09-06','00:00:00','Treinamento gestão faturamento','2025-09-06 21:28:53',1),(12,3,'Alteração de Termo de sindicância','Suporte','Aberto','2025-09-06','18:34:00','2025-09-06','00:00:00','Fazer tarefa','2025-09-06 21:35:09',1),(13,3,'teste','Reunião Tira Dúvida','Concluído','2025-09-06','18:56:00','2025-09-06','00:00:00','teste','2025-09-06 21:56:21',1),(17,3,'rwfdsfasf','Suporte','Aberto','2025-09-07','19:24:00','2025-09-07','00:00:00','','2025-09-06 22:24:09',1),(18,2,'teste','Suporte','Aberto','2025-09-07','19:39:00','2025-09-07','00:00:00','','2025-09-06 22:39:22',1),(20,2,'teste','Suporte','Aberto','2025-09-07','20:57:00','2025-09-07','00:00:00','','2025-09-06 22:57:03',1),(21,2,'estetetwetwe','Suporte','Aberto','2025-09-07','03:06:00','2025-09-07','00:00:00','','2025-09-07 06:06:15',1);
/*!40000 ALTER TABLE `chamados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'GYN PROTECT','','','2025-09-06 01:27:11'),(2,'SOLIDY','','','2025-09-06 01:27:23'),(3,'AGSMB','','','2025-09-06 01:27:30');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisicoes`
--

DROP TABLE IF EXISTS `requisicoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requisicoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `status` enum('Em avaliação','Vai Atender','Não Vai Atender') NOT NULL,
  `data` date NOT NULL,
  `previsao_entrega` date DEFAULT NULL,
  `colaborador` varchar(255) NOT NULL,
  `sugestao` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `requisicoes_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisicoes`
--

LOCK TABLES `requisicoes` WRITE;
/*!40000 ALTER TABLE `requisicoes` DISABLE KEYS */;
INSERT INTO `requisicoes` VALUES (2,3,'Em avaliação','2025-09-14','2025-09-29','Julia','Criar novo campo em boleto'),(3,1,'Em avaliação','2025-09-22','2025-09-15','james','criar ');
/*!40000 ALTER TABLE `requisicoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Stony','stonyvb@gmail.com','$2y$10$jo.4Fg5gsT5nrq0tpfipLuIpPChQLnGEH.wq/ytzvMJa..ToAwZ4S','2025-09-06 01:26:41'),(2,'Walysson','walysson@gmail.com','$2y$10$CJtZqvDeqFB6k9cUoRMBC.U4WIW1gmYFWlg9LfvBg31C/R8QVsN.q','2025-09-06 01:59:34');
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

-- Dump completed on 2025-09-07 14:08:44

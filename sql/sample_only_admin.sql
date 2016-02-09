-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: myblog-db
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Dumping data for table `mybloguser`
--

LOCK TABLES `mybloguser` WRITE;
/*!40000 ALTER TABLE `mybloguser` DISABLE KEYS */;
INSERT INTO `mybloguser` VALUES (1,'admin','40bd001563085fc35165329ea1ff5c5ecbdbbeef',1),(2,'user1','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(3,'user2','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(4,'user3','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(5,'user4','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(6,'user4','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(7,'user5','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0),(8,'userm','40bd001563085fc35165329ea1ff5c5ecbdbbeef',0);
/*!40000 ALTER TABLE `mybloguser` ENABLE KEYS */;
UNLOCK TABLES;


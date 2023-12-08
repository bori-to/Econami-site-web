-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: econami
-- ------------------------------------------------------
-- Server version	10.5.19-MariaDB-0+deb11u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abs_users`
--

DROP TABLE IF EXISTS `abs_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_abs` varchar(128) DEFAULT NULL,
  `actif` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_users`
--

LOCK TABLES `abs_users` WRITE;
/*!40000 ALTER TABLE `abs_users` DISABLE KEYS */;
INSERT INTO `abs_users` VALUES (1,'1 mois',1),(2,'3 mois',0),(3,'6 mois',0),(4,'1 an',0);
/*!40000 ALTER TABLE `abs_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annonce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon` varchar(128) DEFAULT NULL,
  `reduction` float DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `marque` varchar(128) DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `valide` int(11) DEFAULT 0,
  `id_users` int(11) DEFAULT NULL,
  `date_expiration` datetime DEFAULT NULL,
  `top` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annonce`
--

LOCK TABLES `annonce` WRITE;
/*!40000 ALTER TABLE `annonce` DISABLE KEYS */;
INSERT INTO `annonce` VALUES (1,'XRT2015',50,55,'Nike','€','2023-04-06 20:31:15',2,1,'2023-05-17 16:15:15',0),(2,'XRHY015',25,50,'Adidas','%','2023-04-07 16:31:15',2,1,'2023-06-27 11:15:15',0),(3,'ADHY015',10,8,'Sephora','€','2023-03-22 16:32:15',2,1,'2024-01-01 08:17:25',0),(4,'ADHY015',10,8,'Sephora','€','2023-03-22 16:32:15',2,1,'2023-08-11 08:00:00',0),(5,'XAHY189',35,30,'Carrefour','%','2023-02-17 16:15:15',2,1,NULL,0),(6,'123456',15,20,'nike','€','2023-04-27 00:00:00',2,4,'2023-04-29 00:00:00',0),(7,'4vfs956',50,40,'LDLC','€','2023-04-28 00:00:00',1,2,'2023-05-07 00:00:00',0),(8,'4vfs956',40,50,'LDLC','%','2023-04-28 00:00:00',2,2,'2023-05-05 00:00:00',0),(9,'JOYEUXNOEL2022',40,50,'LDLC','%','2023-04-28 00:00:00',2,2,'2023-05-07 00:00:00',0),(10,'SIUUU78',15,40,'LDLC','%','2023-04-28 00:00:00',2,2,'2023-05-07 00:00:00',0),(11,'12345602',15,25,'ikea','€','2023-05-04 00:00:00',2,1,'2023-05-06 00:00:00',0),(16,'123456885',25,50,'ikea','%','2023-05-06 00:00:00',3,1,'2023-12-28 00:00:00',0),(17,'124578',25,26,'Nike','€','2023-05-01 00:00:00',3,1,'2023-12-31 00:00:00',0),(18,'235689',78,80,'Fnac','€','2023-04-30 00:00:00',3,1,'2023-06-01 00:00:00',0),(25,'81498414891',35,40,'NIKE','€','2023-04-30 00:00:00',2,2,'2023-05-05 00:00:00',0),(26,'81498414891',35,400,'1','€','2023-04-30 00:00:00',1,2,'2023-05-07 00:00:00',0),(27,'1',35,400,'NIKE','€','2023-04-30 00:00:00',1,2,'2023-05-07 00:00:00',0),(28,'81498414891',40,50,'NIKE','€','2023-04-30 00:00:00',1,2,'2023-05-07 00:00:00',0),(30,'124578',15,10,'IKEA','€','2023-05-01 00:00:00',2,7,'2024-11-01 00:00:00',0),(31,'124578',100,80,'H&amp;M','€','2023-05-02 00:00:00',1,4,'2023-06-01 00:00:00',1),(32,'235689',14,10,'azerty','€','2023-05-02 00:00:00',2,1,'2023-06-09 00:00:00',0),(33,'8543456789',40,28,'monoprix','€','2023-05-03 00:00:00',2,3,'2023-05-13 00:00:00',0),(34,'3456789987654',30,10,'apple','%','2023-05-03 00:00:00',2,3,'2023-06-24 00:00:00',0),(35,'258147',25,20,'h&amp;m','€','2023-05-04 00:00:00',1,1,'2023-06-10 00:00:00',3),(36,'8765432356789',50,20,'myprotein','%','2023-05-04 00:00:00',1,3,'2023-06-11 00:00:00',2),(37,'124578',50,25,'nike','€','2023-05-30 00:00:00',3,1,'2023-06-01 00:00:00',0),(39,'124578',25,20,'nike','€','2023-05-05 00:00:00',1,1,'2023-06-01 00:00:00',0),(40,'124578',25,20,'azerty','€','2023-05-05 00:00:00',0,1,'2023-06-01 00:00:00',0),(41,'124578',25,20,'nike','€','2023-05-05 00:00:00',0,1,'2023-06-01 00:00:00',0),(42,'12345678',25,20,'azert','€','2023-05-05 00:00:00',0,1,'2023-06-01 00:00:00',0),(43,'124578',25,20,'u,jnhbg','€','2023-05-05 00:00:00',0,1,'2023-06-01 00:00:00',0),(44,'6780°',99,50,'Le coin du daron','€','2023-05-05 00:00:00',1,13,'2023-05-17 00:00:00',0),(45,'HJAEZLAHEAESQDQDADZ',4,2,'Le coin du daron','€','2023-05-05 00:00:00',1,13,'2023-05-24 00:00:00',0),(46,'124578',30,25,'Auchan','€','2023-05-05 00:00:00',0,1,'2023-06-01 00:00:00',0),(47,'124578',12,20,'nike','%','2023-05-06 00:00:00',0,1,'2023-06-01 00:00:00',0),(48,'258741',25,20,'                     h&amp;m                         ','€','2023-05-06 00:00:00',0,1,'2023-06-01 00:00:00',0),(49,'235689',20,15,'H&amp;M','€','2023-05-06 00:00:00',0,1,'2023-06-01 00:00:00',0),(50,'8543456789',11,4,'nike','€','2023-05-20 00:00:00',3,3,'2023-05-25 00:00:00',0),(51,'8543456789',4,3,'nike','€','2023-05-21 00:00:00',3,3,'2023-05-19 00:00:00',0),(52,'6545789032345',11,7,'auchant','€','2023-05-07 00:00:00',0,3,'2023-05-25 00:00:00',0),(53,'235689',30,35,'H&amp;M','%','2023-05-07 00:00:00',0,1,'2023-06-01 00:00:00',0),(54,'81498414891',40,35,'NIKE','€','2023-06-01 00:00:00',3,2,'2023-05-17 00:00:00',0);
/*!40000 ALTER TABLE `annonce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `paiement_montant` float NOT NULL,
  `paiement_monnaie` varchar(10) NOT NULL,
  `txn_id` varchar(50) NOT NULL,
  `paiement_statue` varchar(25) NOT NULL,
  `stripe_checkout_session_id` varchar(100) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  KEY `id_annonce` (`id_annonce`),
  CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`),
  CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES (1,2,2,50,'EUR','pi_3N1F67EmonlTtdhv0GlL21Tk','succeeded','cs_test_a1jJWW9CBbp45gAKQH0sKPWzDht3ysf04Yo2ueSwOEgIBjuWLwQypkWEXz','2023-04-26 22:37:58','2023-04-26 22:37:58'),(2,4,3,8,'EUR','pi_3N1QuyEmonlTtdhv1XRela2r','succeeded','cs_test_a10iuQUzsr0xy0U7zy7HPHPIHuEoTKsllEDfpG0zN6KeGhLJwbZPORtg0L','2023-04-27 11:15:16','2023-04-27 11:15:16'),(3,4,3,8,'EUR','pi_3N1QyfEmonlTtdhv1X73BtNZ','succeeded','cs_test_a16intSFYbIS0jdHjKGxhf3n4pTCrGlKdcxK8EpO8Hq17cZgEIRRjmIuyA','2023-04-27 11:19:04','2023-04-27 11:19:04'),(4,4,4,8,'EUR','pi_3N1RV6EmonlTtdhv0jPHeGpY','succeeded','cs_test_a15qpydGkYydw4zFqmbAWz5TJDr7gqWvXcDqDvDwHKpGORf5dcv5K5u8TJ','2023-04-27 11:52:35','2023-04-27 11:52:35'),(5,1,6,20,'EUR','pi_3N1RebEmonlTtdhv1KyGx4Pg','succeeded','cs_test_a1zzgk9FTIUOrKW9iznuMyswyFr2Jmy7lROR8cogla8ZjUUgHB9j5mWQpp','2023-04-27 12:02:22','2023-04-27 12:02:22'),(8,7,10,40,'EUR','pi_3N33YEEmonlTtdhv06atrtoZ','succeeded','cs_test_a1HshYGjUxGMzUP95ioAKToGDYjYATgKqwQhUqSIlG6XjDUbMIpwpqHpcP','2023-05-01 22:42:29','2023-05-01 22:42:29'),(9,1,25,40,'EUR','pi_3N3cu0EmonlTtdhv005c8Q23','succeeded','cs_test_a10V6Gk8Idr4Q25c81GkWIawbOktpcuqOKNYbrIE7uFQldCz0JXR4gP7N9','2023-05-03 12:27:17','2023-05-03 12:27:17'),(10,1,8,78,'EUR','pi_3N3cvvEmonlTtdhv0Xb41GB7','succeeded','cs_test_a1txRq971CbgoNMW46vwC1GK1o2s057ETBlgLFeR8hrqPeW76h9AJYtg5m','2023-05-03 12:29:16','2023-05-03 12:29:16'),(11,1,33,78,'EUR','pi_3N3cvvEmonlTtdhv0Xb41GB7','succeeded','cs_test_a1txRq971CbgoNMW46vwC1GK1o2s057ETBlgLFeR8hrqPeW76h9AJYtg5m','2023-05-03 12:29:16','2023-05-03 12:29:16'),(12,4,11,25,'EUR','pi_3N3dBoEmonlTtdhv0zJRBCPR','succeeded','cs_test_a1411Emjasp7z21GBXT9X3U1walBMqozxu07s0FC0KjdtOFYBQoVfYg3pm','2023-05-03 12:45:42','2023-05-03 12:45:42'),(13,4,32,10,'EUR','pi_3N3dD7EmonlTtdhv11MwJqJP','succeeded','cs_test_a1y3D0h06MyZ2wknDEVMz8mwImrKon7MXzkB2gESELwmOxxifxTffsBa1i','2023-05-03 12:47:03','2023-05-03 12:47:03'),(14,4,1,55,'EUR','pi_3N3dIHEmonlTtdhv12CkmeE2','succeeded','cs_test_a1SJg9MklLxeQV1cJ87a5Hx1W0FQ8X9qVEBIZtXfsviRSqf6nY0tuWGT59','2023-05-03 12:52:23','2023-05-03 12:52:23'),(15,1,30,10,'EUR','pi_3N4RMXEmonlTtdhv1vw0FD3x','succeeded','cs_test_a1vVsxuOIv3uGRWR9xTCvJZmttj5o2amz2Byrst4F3sYVmdZ7KiS3mx4kS','2023-05-05 18:20:08','2023-05-05 18:20:08'),(16,1,34,10,'EUR','pi_3N4mr2EmonlTtdhv0a3BzOy8','succeeded','cs_test_a1HtMoz4itQUJRp6ubSpGxgAmAAlc63UMv04m4peRhwkmHIpA3Aa61XSN6','2023-05-06 17:17:04','2023-05-06 17:17:04');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum`
--

LOCK TABLES `forum` WRITE;
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
INSERT INTO `forum` VALUES (1,'Vendre','vente','2023-03-23 19:38:00',1),(2,'Acheter','achats','2023-03-25 19:38:00',2),(3,'Vip','vi','2023-03-26 19:38:00',3);
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` longtext DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (1,'salut','2023-04-28 08:56:10'),(2,'HAHAHA','2023-04-28 09:20:30'),(3,'?','2023-04-28 09:35:21'),(4,'?','2023-04-28 09:35:23'),(5,'SIUUUUUUUUUUUUU','2023-04-28 09:43:45'),(6,'Le pipi c pas bo','2023-04-28 11:46:58'),(7,'Vous avez gagné un iphone 10\r\n','2023-04-28 11:47:44'),(9,'ha','2023-04-28 11:49:02'),(13,'revtrv','2023-04-28 11:59:34'),(14,'coucou','2023-04-28 12:11:49'),(15,'j\'aimer ca av','2023-04-28 12:15:50'),(16,'Salut ça farte ?','2023-04-28 12:46:27'),(17,'','2023-04-28 12:46:42'),(18,'caca\r\n','2023-04-28 12:46:59'),(19,'','2023-04-28 12:47:05'),(20,'zizi','2023-04-28 12:47:11'),(21,'salam les rhoya\r\n','2023-04-28 12:47:39'),(22,'Quelqu\'une des voix\r\nToujours angélique\r\n- Il s\'agit de moi, -\r\nVertement s\'explique :\r\n\r\nCes mille questions\r\nQui se ramifient\r\nN\'amènent, au fond,\r\nQu\'ivresse et folie ;\r\n\r\nReconnais ce tour\r\nSi gai, si facile :\r\nCe n\'est qu\'onde, flore,\r\nEt c\'est ta famille !\r\n\r\nPuis elle chante. Ô\r\nSi gai, si facile,\r\nEt visible à l\'oeil nu...\r\n- Je chante avec elle, -\r\n\r\nReconnais ce tour\r\nSi gai, si facile,\r\nCe n\'est qu\'onde, flore,\r\nEt c\'est ta famille !... etc...\r\n\r\nEt puis une voix\r\n- Est-elle angélique ! -\r\nIl s\'agit de moi,\r\nVertement s\'explique ;\r\n\r\nEt chante à l\'instant\r\nEn soeur des haleines :\r\nD\'un ton Allemand,\r\nMais ardente et pleine :\r\n\r\nLe monde est vicieux ;\r\nSi cela t\'étonne !\r\nVis et laisse au feu\r\nL\'obscure infortune.\r\n\r\nÔ ! joli château !\r\nQue ta vie est claire !\r\nDe quel Age es-tu,\r\nNature princière\r\nDe notre grand frère ! etc...\r\n\r\nJe chante aussi, moi :\r\nMultiples soeurs ! voix\r\nPas du tout publiques !\r\nEnvironnez-moi\r\nDe gloire pudique... etc...\r\nÀ découvrir sur le site https://www.poesie-francaise.fr/arthur-rimbaud/poeme-age-d-or.php\r\n','2023-04-28 12:49:11'),(23,'boufe mon poireau \r\n','2023-04-28 12:49:23'),(24,'jkehkugs\r\n','2023-04-28 12:49:30'),(25,'gang','2023-05-03 00:48:57'),(26,'coucou les louloi','2023-05-03 13:15:14'),(27,'La newsletter est fini','2023-05-04 22:17:39'),(28,'La newsletter est fini','2023-05-04 22:18:32'),(29,'La newsletter est fini','2023-05-04 22:21:05'),(30,'Let\'s go c\'est le test la','2023-05-04 22:21:17');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters_send`
--

DROP TABLE IF EXISTS `newsletters_send`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_send` varchar(128) DEFAULT NULL,
  `actif` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters_send`
--

LOCK TABLES `newsletters_send` WRITE;
/*!40000 ALTER TABLE `newsletters_send` DISABLE KEYS */;
INSERT INTO `newsletters_send` VALUES (1,'1 jour',0),(2,'1 semaine',1),(3,'1 mois',0);
/*!40000 ALTER TABLE `newsletters_send` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_forum` int(11) DEFAULT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `contenu` longtext DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_forum` (`id_forum`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`id_forum`) REFERENCES `forum` (`id`),
  CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES (1,1,'Titre topic modifier le topic','le texte du topic ici. modifier','2023-03-26 07:53:45','2023-03-28 16:16:18',1,0),(2,1,'deuxième topic','Deuxième Topic incroyablement drôle !!\r\n\r\nBonne journée :)','2023-03-27 07:59:25','2023-03-27 07:59:25',1,0),(3,2,'Trois topic','Topic numéro 3','2023-03-27 07:59:25','2023-03-27 07:59:25',1,0),(4,2,'Problème','azertyuiopqsdf\r\nghjklmwxcvbn','2023-03-27 20:21:19','2023-03-27 20:21:19',1,0),(5,3,'Avantage VIP','Quelle sont les avantages du VIP ?','2023-03-27 20:22:15','2023-03-27 20:22:15',1,0),(6,3,'J\'aime les DAN','Comment cacher la nourriture de Dan ???','2023-03-29 09:52:54','2023-03-29 09:53:07',1,0),(8,1,'Projet Annuel','Le PA c\'est trop bien','2023-05-01 22:34:58','2023-05-01 22:34:58',7,0),(9,1,'Probleme de chargeur','problemmmmme','2023-05-04 01:31:58','2023-05-04 01:32:35',3,0),(10,3,'Uujh','ufyj','2023-05-05 00:31:28','2023-05-05 00:31:28',3,0);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_commentaire`
--

DROP TABLE IF EXISTS `topic_commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_topic` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `contenu` longtext NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_topic` (`id_topic`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `topic_commentaire_ibfk_1` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id`),
  CONSTRAINT `topic_commentaire_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_commentaire`
--

LOCK TABLES `topic_commentaire` WRITE;
/*!40000 ALTER TABLE `topic_commentaire` DISABLE KEYS */;
INSERT INTO `topic_commentaire` VALUES (1,1,1,'Voici mon premier commentaire sur ce topic ;)','2023-03-28 15:47:30','2023-03-28 16:32:34'),(2,1,1,'c\'est cool 15','2023-03-28 16:47:30','2023-03-28 16:30:50'),(4,4,1,'premier commentaire de Problème !','2023-03-29 19:39:28','2023-03-29 19:39:28'),(7,1,1,'Troisième','2023-03-29 22:00:23','2023-03-29 22:00:23'),(8,1,1,'Prout','2023-03-30 10:07:57','2023-03-30 10:07:57'),(9,1,1,'cezceccercre','2023-03-30 10:13:26','2023-04-26 21:08:27'),(10,6,1,'coucou','2023-04-29 21:24:57','2023-04-29 21:24:57'),(13,8,7,'Comment ca mon keuf ?','2023-05-01 22:35:30','2023-05-01 22:35:30'),(14,6,1,'cocuou','2023-05-03 00:15:23','2023-05-03 00:15:23'),(17,2,1,'encore un','2023-05-03 00:15:51','2023-05-03 00:15:51'),(18,4,3,'test ok','2023-05-05 00:32:02','2023-05-07 09:56:14');
/*!40000 ALTER TABLE `topic_commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age` datetime DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `newsletter` varchar(5) DEFAULT NULL,
  `type` int(11) DEFAULT 0,
  `solde` float DEFAULT 0,
  `date_visite` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1895-01-30 00:00:00',286,'adrien0878@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','borito','image-1683466314.png','Pimbel','Adrien','true',1,344,'2023-05-07 17:14:30'),(2,NULL,180,'nathandspro@gmail.com','d9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85','NathanBGdu78','image-1683467674.png','Dasilva','Nathan','true',1,230,'2023-05-07 17:42:49'),(3,'2003-09-15 00:00:00',300,'danbzerbib9@gmail.com','16a6b06640a8fa482361da6181d5b2cbc086c193b6a0aeb01482145ed87edebef172a9e7210abf1903ab3c1f7e19940e0ef9d2682563bdacaa84a3a060affff2','etctra','image-1683466869.png','ZERBIB','DAN','true',1,394,'2023-05-07 15:25:40'),(4,NULL,340,'lipoutousama@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','lipou','image-1683326567.png','lipou','lipou','true',0,116,'2023-05-06 00:39:46'),(7,'2000-01-01 00:00:00',50,'esgieconami@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','esgi1','image-1683305918.png','esgi','esgi','false',0,50,'2023-05-07 01:21:49'),(8,'2000-01-01 00:00:00',0,'cenimoi@gmail.com','e9b77609149c1fb588066d20dde253237e0dfefcf616ca49ab94002783c36e13e86dffbdd3b407f534cc7829879a394a2cdae381c9460c1843119a96585e49b8','non',NULL,'oui','moi','false',0,0,'2023-05-05 16:00:19'),(13,NULL,0,'arkayz@hotmail.com','a5e88b62d4257b00197d08491cab6ca773a4c2c31851ab8656ee32491bc20a6347e8153adf14faef00d7650a60c0697481385e21eb308d0421e9da20ad92db31','Arkayz',NULL,'Zhuang','Franck','false',0,0,'2023-05-05 20:17:46'),(15,NULL,0,'attoungbreha@hotmail.com','df6b9fb15cfdbb7527be5a8a6e39f39e572c8ddb943fbc79a943438e9d3d85ebfc2ccf9e0eccd9346026c0b6876e0e01556fe56f135582c05fbdbb505d46755a','Haruya',NULL,'Attoungbre','Hallya','true',0,0,'2023-05-07 05:15:12'),(17,NULL,0,'econami.esgi@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','ESGITR','image-1683466188.png','esgi','esgi','false',0,0,'2023-05-07 14:34:58'),(18,NULL,0,'kevinsureshe@gmail.com','53cb2c6da7ecedfcf6c68731d0133a63065f708f4389750e67c44f766daa5c0020739e61ead02aebcabaa892d4f203aa52fb96e0a770b3fa32f3521cfa772467','sitron','image-1683467973.png','sureshe','kevin','true',0,0,'2023-05-07 15:55:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-07 16:05:26

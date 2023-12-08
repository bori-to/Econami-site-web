-- MariaDB dump 10.19  Distrib 10.5.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: econami
-- ------------------------------------------------------
-- Server version	10.5.18-MariaDB-0+deb11u1

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
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annonce`
--

LOCK TABLES `annonce` WRITE;
/*!40000 ALTER TABLE `annonce` DISABLE KEYS */;
INSERT INTO `annonce` VALUES (1,'XRT2015',50,55,'Nike','€','2023-04-06 20:31:15',1,1,'2023-05-17 16:15:15'),(2,'XRHY015',25,50,'Adidas','%','2023-04-07 16:31:15',2,1,'2023-06-27 11:15:15'),(3,'ADHY015',10,8,'Sephora','€','2023-03-22 16:32:15',2,1,'2024-01-01 08:17:25'),(4,'ADHY015',10,8,'Sephora','€','2023-03-22 16:32:15',2,1,'2023-08-11 08:00:00'),(5,'XAHY189',35,30,'Carrefour','%','2023-02-17 16:15:15',2,1,NULL),(6,'123456',15,20,'nike','€','2023-04-27 00:00:00',2,4,'2023-04-29 00:00:00'),(7,'4vfs956',50,40,'LDLC','€','2023-04-28 00:00:00',1,2,'2023-05-07 00:00:00'),(8,'4vfs956',40,50,'LDLC','%','2023-04-28 00:00:00',1,2,'2023-05-05 00:00:00'),(9,'JOYEUXNOEL2022',40,50,'LDLC','%','2023-04-28 00:00:00',1,2,'2023-05-07 00:00:00'),(10,'SIUUU78',15,40,'LDLC','%','2023-04-28 00:00:00',1,2,'2023-05-07 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES (1,2,2,50,'EUR','pi_3N1F67EmonlTtdhv0GlL21Tk','succeeded','cs_test_a1jJWW9CBbp45gAKQH0sKPWzDht3ysf04Yo2ueSwOEgIBjuWLwQypkWEXz','2023-04-26 22:37:58','2023-04-26 22:37:58'),(2,4,3,8,'EUR','pi_3N1QuyEmonlTtdhv1XRela2r','succeeded','cs_test_a10iuQUzsr0xy0U7zy7HPHPIHuEoTKsllEDfpG0zN6KeGhLJwbZPORtg0L','2023-04-27 11:15:16','2023-04-27 11:15:16'),(3,4,3,8,'EUR','pi_3N1QyfEmonlTtdhv1X73BtNZ','succeeded','cs_test_a16intSFYbIS0jdHjKGxhf3n4pTCrGlKdcxK8EpO8Hq17cZgEIRRjmIuyA','2023-04-27 11:19:04','2023-04-27 11:19:04'),(4,4,4,8,'EUR','pi_3N1RV6EmonlTtdhv0jPHeGpY','succeeded','cs_test_a15qpydGkYydw4zFqmbAWz5TJDr7gqWvXcDqDvDwHKpGORf5dcv5K5u8TJ','2023-04-27 11:52:35','2023-04-27 11:52:35'),(5,1,6,20,'EUR','pi_3N1RebEmonlTtdhv1KyGx4Pg','succeeded','cs_test_a1zzgk9FTIUOrKW9iznuMyswyFr2Jmy7lROR8cogla8ZjUUgHB9j5mWQpp','2023-04-27 12:02:22','2023-04-27 12:02:22'),(6,5,5,30,'EUR','pi_3N1RxhEmonlTtdhv1ErmLT3o','succeeded','cs_test_a188stTLDXxsuVj3jhWRG3rQVg24iw2AOEmvTZ5XUx6H9mxK9ElrfEUOhz','2023-04-27 12:22:08','2023-04-27 12:22:08');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (1,'salut','2023-04-28 08:56:10'),(2,'HAHAHA','2023-04-28 09:20:30'),(3,'?','2023-04-28 09:35:21'),(4,'?','2023-04-28 09:35:23'),(5,'SIUUUUUUUUUUUUU','2023-04-28 09:43:45'),(6,'Le pipi c pas bo','2023-04-28 11:46:58'),(7,'Vous avez gagné un iphone 10\r\n','2023-04-28 11:47:44'),(8,'<!DOCTYPE html>\r\n<html>\r\n<head>\r\n	<title>Email econami</title>\r\n	<meta charset=\"utf-8\">\r\n	<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ\" crossorigin=\"anonymous\">\r\n	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/paiement.css\">\r\n	<style type=\"text/css\">\r\n		div{\r\n		  font-size:25pt;\r\n		}\r\n		.a{\r\n		  font-size:50pt;\r\n		}\r\n		.a img{\r\n		  width: 200px;\r\n		}\r\n		.para{\r\n			font-size: 16px;\r\n		}\r\n\r\n		.forum__body__btn {\r\n		    margin: 20px 0;\r\n		}\r\n		.forum__btn__create {\r\n		    background: #DCD488;\r\n		    color: black;\r\n		    align-items: center;\r\n		    cursor: pointer;\r\n		    border: 0;\r\n		    padding: 0.375rem;\r\n		    border-radius: 6px;\r\n		    font-size: .8rem;\r\n		    text-decoration: none;\r\n		    box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);\r\n		    transition: all .5s ease;\r\n		    justify-content: center;\r\n		}\r\n		.forum__btn__create:hover {\r\n		    box-shadow: none;\r\n		}\r\n	</style>\r\n</head>\r\n<body style=\"background-color: #f6f9fc;\">\r\n	<br>\r\n	<div class=\"container\">\r\n		<div class=\"row\">\r\n			<div class=\"col-3\"></div>\r\n			<div class=\"col-6\" style=\"background-color: rgba(185, 168, 124, 0.5); border-radius: 10px;\">\r\n				<div class=\"a\">\r\n					<img src=\"https://econami.ddns.net/images/econami2.png\">\r\n				</div>\r\n				<div>\r\n				  <p class=\"para\">paragraphe du mail</p>\r\n				  <div class=\"forum__body__btn\">\r\n						<a href=\"https://econami.ddns.net/\" class=\"forum__btn__create\" style=\"background-color: #DCD488; font-size: 16px;\">\r\n							Texte du bouton\r\n						</a>\r\n					</div>\r\n					<p class=\"para\">Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>\r\n					<p class=\"para\">Merci,<br><mark>Econami</mark></p>\r\n					<p class=\"para\">© 2023 <mark>Econami</mark>, Inc</p>\r\n				</div>\r\n			</div>\r\n			<div class=\"col-3\"></div>\r\n		</div>\r\n	</div>\r\n</body>\r\n</html>','2023-04-28 11:48:21'),(9,'ha','2023-04-28 11:49:02'),(10,'<!DOCTYPE html>\r\n      <html>\r\n      <head>\r\n        <title>Email econami</title>\r\n        <meta charset=\'utf-8\'>\r\n        <link href=\'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css\' rel=\'stylesheet\' integrity=\'sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ\' crossorigin=\'anonymous\'>\r\n        <style type=\'text/css\'>\r\n          .a{\r\n            font-size:50pt;\r\n            color: black;\r\n          }\r\n          .a img{\r\n            width: 200px;\r\n          }\r\n          .para{\r\n            font-size: 16px;\r\n          }\r\n\r\n          mark{\r\n            background-color: #DCD488;\r\n          }\r\n\r\n          button{\r\n            border: none;\r\n            background-color: rgba(185, 168, 124,0);\r\n          }\r\n\r\n          .forum__body__btn {\r\n              margin: 20px 0;\r\n          }\r\n          .forum__btn__create {\r\n              background: #DCD488;\r\n              color: black;\r\n              align-items: center;\r\n              cursor: pointer;\r\n              border: 0;\r\n              padding: 0.375rem;\r\n              border-radius: 6px;\r\n              font-size: .8rem;\r\n              text-decoration: none;\r\n              box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);\r\n              transition: all .5s ease;\r\n              justify-content: center;\r\n          }\r\n          .forum__btn__create:hover {\r\n              box-shadow: none;\r\n          }\r\n        </style>\r\n      </head>\r\n      <body style=\'background-color: #f6f9fc;\'>\r\n        <div class=\'container\'>\r\n          <div class=\'row\'>\r\n            <div class=\'col-3\'></div>\r\n            <div class=\'col-6\' style=\'background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;\'>\r\n              <div class=\'a\'>\r\n                <img src=\'https://econami.ddns.net/images/econami2.png\'>\r\n              </div>\r\n              <div>\r\n                <p class=\'para\'>Demande de transfère d\'argent d\'un montant de <b>$solde €</b> à valider pour <b>$pseudo</b>,<br> Numéro IBAN : <b>$iban</b></p>\r\n                <button class=\'forum__body__btn\'>\r\n                  <a href=\'https://econami.ddns.net/\' class=\'forum__btn__create\' style=\'background-color: #DCD488; font-size: 25px; color: black;\'>\r\n                    Econami\r\n                  </a>\r\n                </button>\r\n                <p class=\'para\'>Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>\r\n                <p class=\'para\'>Merci,<br><mark>Econami</mark></p>\r\n                <p class=\'para\'>© 2023 <mark>Econami</mark>, Inc</p>\r\n              </div>\r\n            </div>\r\n            <div class=\'col-3\'></div>\r\n          </div>\r\n        </div>\r\n      </body>\r\n      </html>','2023-04-28 11:55:08'),(11,' <!DOCTYPE html>\r\n      <html>\r\n      <head>\r\n        <title>Email econami</title>\r\n        <meta charset=\'utf-8\'>\r\n        <link href=\'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css\' rel=\'stylesheet\' integrity=\'sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ\' crossorigin=\'anonymous\'>\r\n        <style type=\'text/css\'>\r\n          .m_a{\r\n            font-size:50pt;\r\n            color: black;\r\n          }\r\n          .m_a img{\r\n            width: 200px;\r\n          }\r\n          .para{\r\n            font-size: 16px;\r\n          }\r\n\r\n          mark{\r\n            background-color: #DCD488;\r\n          }\r\n\r\n          button{\r\n            border: none;\r\n            background-color: rgba(185, 168, 124,0);\r\n          }\r\n\r\n          .forum__body__btn {\r\n              margin: 20px 0;\r\n          }\r\n          .forum__btn__create {\r\n              background: #DCD488;\r\n              color: black;\r\n              align-items: center;\r\n              cursor: pointer;\r\n              border: 0;\r\n              padding: 0.375rem;\r\n              border-radius: 6px;\r\n              font-size: .8rem;\r\n              text-decoration: none;\r\n              box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);\r\n              transition: all .5s ease;\r\n              justify-content: center;\r\n          }\r\n          .forum__btn__create:hover {\r\n              box-shadow: none;\r\n          }\r\n        </style>\r\n      </head>\r\n      <body style=\'background-color: #f6f9fc;\'>\r\n        <div class=\'container\'>\r\n          <div class=\'row\'>\r\n            <div class=\'col-3\'></div>\r\n            <div class=\'col-6\' style=\'background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;\'>\r\n              <div class=\'m_a\'>\r\n                <img src=\'https://econami.ddns.net/images/econami2.png\'>\r\n              </div>\r\n              <div>\r\n                <p class=\'para\'>Bonjour $pseudo,<br>Ta demande de Transfère Avec montant de <b>$solde €</b> à bien était prise en compte.</p>\r\n                <button class=\'forum__body__btn\'>\r\n                  <a href=\'https://econami.ddns.net/\' class=\'forum__btn__create\' style=\'background-color: #DCD488; font-size: 25px; color: black;\'>\r\n                    Econami\r\n                  </a>\r\n                </button>\r\n                <p class=\'para\'>Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>\r\n                <p class=\'para\'>Merci,<br><mark>Econami</mark></p>\r\n                <p class=\'para\'>© 2023 <mark>Econami</mark>, Inc</p>\r\n              </div>\r\n            </div>\r\n            <div class=\'col-3\'></div>\r\n          </div>\r\n        </div>\r\n      </body>\r\n      </html>','2023-04-28 11:57:12'),(12,'<!DOCTYPE html>\r\n      <html>\r\n      <head>\r\n        <title>Email econami</title>\r\n        <meta charset=\'utf-8\'>\r\n        <link href=\'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css\' rel=\'stylesheet\' integrity=\'sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ\' crossorigin=\'anonymous\'>\r\n        <style type=\'text/css\'>\r\n          .m_a{\r\n            font-size:50pt;\r\n            color: black;\r\n          }\r\n          .m_a img{\r\n            width: 200px;\r\n          }\r\n\r\n          mark{\r\n            background-color: #DCD488;\r\n          }\r\n\r\n          button{\r\n            border: none;\r\n            background-color: rgba(185, 168, 124,0);\r\n          }\r\n\r\n          .forum__body__btn {\r\n              margin: 20px 0;\r\n          }\r\n          .forum__btn__create {\r\n              background: #DCD488;\r\n              color: black;\r\n              align-items: center;\r\n              cursor: pointer;\r\n              border: 0;\r\n              padding: 0.375rem;\r\n              border-radius: 6px;\r\n              font-size: .8rem;\r\n              text-decoration: none;\r\n              box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);\r\n              transition: all .5s ease;\r\n              justify-content: center;\r\n          }\r\n          .forum__btn__create:hover {\r\n              box-shadow: none;\r\n          }\r\n        </style>\r\n      </head>\r\n      <body style=\'background-color: #f6f9fc;\'>\r\n        <div class=\'container\'>\r\n          <div class=\'row\'>\r\n            <div class=\'col-3\'></div>\r\n            <div class=\'col-6\' style=\'background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;\'>\r\n              <div class=\'m_a\'>\r\n                <img src=\'https://econami.ddns.net/images/econami2.png\'>\r\n              </div>\r\n              <div>\r\n                <p>Demande de transfère d\'argent d\'un montant de <b>$solde €</b> à valider pour <b>$pseudo</b>,<br> Numéro IBAN : <b>$iban</b></p>\r\n                <button class=\'forum__body__btn\'>\r\n                  <a href=\'https://econami.ddns.net/\' class=\'forum__btn__create\' style=\'background-color: #DCD488; font-size: 25px; color: black;\'>\r\n                    Econami\r\n                  </a>\r\n                </button>\r\n                <p class=\'para\'>Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>\r\n                <p class=\'para\'>Merci,<br><mark>Econami</mark></p>\r\n                <p class=\'para\'>© 2023 <mark>Econami</mark>, Inc</p>\r\n              </div>\r\n            </div>\r\n            <div class=\'col-3\'></div>\r\n          </div>\r\n        </div>\r\n      </body>\r\n      </html>','2023-04-28 11:58:18'),(13,'revtrv','2023-04-28 11:59:34'),(14,'coucou','2023-04-28 12:11:49'),(15,'j\'aimer ca av','2023-04-28 12:15:50'),(16,'Salut ça farte ?','2023-04-28 12:46:27'),(17,'','2023-04-28 12:46:42'),(18,'caca\r\n','2023-04-28 12:46:59'),(19,'','2023-04-28 12:47:05'),(20,'zizi','2023-04-28 12:47:11'),(21,'salam les rhoya\r\n','2023-04-28 12:47:39'),(22,'Quelqu\'une des voix\r\nToujours angélique\r\n- Il s\'agit de moi, -\r\nVertement s\'explique :\r\n\r\nCes mille questions\r\nQui se ramifient\r\nN\'amènent, au fond,\r\nQu\'ivresse et folie ;\r\n\r\nReconnais ce tour\r\nSi gai, si facile :\r\nCe n\'est qu\'onde, flore,\r\nEt c\'est ta famille !\r\n\r\nPuis elle chante. Ô\r\nSi gai, si facile,\r\nEt visible à l\'oeil nu...\r\n- Je chante avec elle, -\r\n\r\nReconnais ce tour\r\nSi gai, si facile,\r\nCe n\'est qu\'onde, flore,\r\nEt c\'est ta famille !... etc...\r\n\r\nEt puis une voix\r\n- Est-elle angélique ! -\r\nIl s\'agit de moi,\r\nVertement s\'explique ;\r\n\r\nEt chante à l\'instant\r\nEn soeur des haleines :\r\nD\'un ton Allemand,\r\nMais ardente et pleine :\r\n\r\nLe monde est vicieux ;\r\nSi cela t\'étonne !\r\nVis et laisse au feu\r\nL\'obscure infortune.\r\n\r\nÔ ! joli château !\r\nQue ta vie est claire !\r\nDe quel Age es-tu,\r\nNature princière\r\nDe notre grand frère ! etc...\r\n\r\nJe chante aussi, moi :\r\nMultiples soeurs ! voix\r\nPas du tout publiques !\r\nEnvironnez-moi\r\nDe gloire pudique... etc...\r\nÀ découvrir sur le site https://www.poesie-francaise.fr/arthur-rimbaud/poeme-age-d-or.php\r\n','2023-04-28 12:49:11'),(23,'boufe mon poireau \r\n','2023-04-28 12:49:23'),(24,'jkehkugs\r\n','2023-04-28 12:49:30');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES (1,1,'Titre topic modifier le topic','le texte du topic ici. modifier','2023-03-26 07:53:45','2023-03-28 16:16:18',1,0),(2,1,'deuxième topic','Deuxième Topic incroyablement drôle !!\r\n\r\nBonne journée :)','2023-03-27 07:59:25','2023-03-27 07:59:25',1,0),(3,2,'Trois topic','Topic numéro 3','2023-03-27 07:59:25','2023-03-27 07:59:25',1,0),(4,2,'Problème','azertyuiopqsdf\r\nghjklmwxcvbn','2023-03-27 20:21:19','2023-03-27 20:21:19',1,0),(5,3,'Avantage VIP','Quelle sont les avantages du VIP ?','2023-03-27 20:22:15','2023-03-27 20:22:15',1,0),(6,3,'J\'aime les DAN','Comment cacher la nourriture de Dan ???','2023-03-29 09:52:54','2023-03-29 09:53:07',1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_commentaire`
--

LOCK TABLES `topic_commentaire` WRITE;
/*!40000 ALTER TABLE `topic_commentaire` DISABLE KEYS */;
INSERT INTO `topic_commentaire` VALUES (1,1,1,'Voici mon premier commentaire sur ce topic ;)','2023-03-28 15:47:30','2023-03-28 16:32:34'),(2,1,1,'c\'est cool 15','2023-03-28 16:47:30','2023-03-28 16:30:50'),(4,4,1,'premier commentaire de Problème !','2023-03-29 19:39:28','2023-03-29 19:39:28'),(7,1,1,'Troisième','2023-03-29 22:00:23','2023-03-29 22:00:23'),(8,1,1,'Prout','2023-03-30 10:07:57','2023-03-30 10:07:57'),(9,1,1,'cezceccercre','2023-03-30 10:13:26','2023-04-26 21:08:27');
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
  `age` varchar(10) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'',58,'adrien0878@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','borito','image-1682600492.jpg','Pimbel','Adrien','true',1,116),(2,NULL,0,'nathandspro@gmail.com','e6786a7a74c7420fb0b21baae5936871e72dac743351abb4a61a9145c3ea19a32c977fd409f53e55740031080a220a19fbe17199ed3c7b95148acdd46eeb49a9','NathanBGdu78',NULL,'Dasilva','Nathan','true',1,50),(3,'1867-07-27',10,'danbzerbib9@gmail.com','16a6b06640a8fa482361da6181d5b2cbc086c193b6a0aeb01482145ed87edebef172a9e7210abf1903ab3c1f7e19940e0ef9d2682563bdacaa84a3a060affff2','etctra',NULL,'ZERBIB','DAN','true',1,356),(4,NULL,28,'lipoutousama@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','lipou','image-1682586557.jpg','lipou','lipou','true',0,36),(5,NULL,30,'esgieconami@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','iuerg',NULL,'tuh','iuer','true',0,30),(6,NULL,0,'econami.esgi@gmail.com','2afa9db5c0bd2d46709f939138913ff6a20e3d1fa298b01ce9764506d414e6df358642feb830fd9aa7e50091dbf291455129798e2863e34ebf3054404cadd769','eco','image-1682676603.png','esgi','econami','true',0,0);
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

-- Dump completed on 2023-04-29 17:10:35

-- MySQL dump 10.14  Distrib 5.5.41-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: mukuru
-- ------------------------------------------------------
-- Server version	5.5.41-MariaDB

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
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `base_exchange_rate` decimal(10,7) NOT NULL,
  `updated_exchange_rate` decimal(10,7) DEFAULT NULL,
  `surcharge_percentage` decimal(10,7) NOT NULL,
  `total_discount_percentage` decimal(10,7) NOT NULL,
  `execute_after` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6956883F5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'US Dollars','USD',0.0808279,NULL,7.5000000,0.0000000,NULL,'2015-10-04 22:15:07',NULL),(2,'British Pound','GBD',0.0527032,NULL,5.0000000,0.0000000,'email','2015-10-04 22:15:07',NULL),(3,'Euro','EUR',0.0718710,NULL,5.0000000,2.0000000,NULL,'2015-10-04 22:15:07',NULL),(4,'Kenyan Shilling','KES',7.8149800,NULL,2.5000000,0.0000000,NULL,'2015-10-04 22:15:07',NULL);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_order`
--

DROP TABLE IF EXISTS `exchange_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exchange_rate` decimal(10,7) NOT NULL,
  `surcharge_percentage` decimal(10,7) NOT NULL,
  `total_discount_percentage` decimal(10,7) NOT NULL,
  `foreign_currency_amount` decimal(20,7) NOT NULL,
  `local_currency_amount` decimal(20,7) NOT NULL,
  `total_billed_amount` decimal(20,7) NOT NULL,
  `surcharge_amount` decimal(10,7) NOT NULL,
  `created` datetime NOT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EB1EDFD038248176` (`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_order`
--

LOCK TABLES `exchange_order` WRITE;
/*!40000 ALTER TABLE `exchange_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(42) COLLATE utf8_unicode_ci NOT NULL,
  `password_salt` varchar(42) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `family_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(201) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'tjaart.viljoen','fd4726199f48dbecd1210ebb0230005de296d4b2','5478f10c4cc5ec744bdbbb8002703d6b62d0abf6','Tjaart','Viljoen','Tjaart Viljoen','tjaartviljoen@gmail.com','+27823897681','Client','2015-10-04 22:15:07'),(2,'test.user','bdc0fc36ea9e45da75640ea6d492350eb5c17c11','14f0ea38884c55a19c9f18a2f47560c2ae50293c','Test','User','Test User','email@here.com','+27821234567','Client','2015-10-04 22:15:07');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-04 22:15:46

-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: eprojects1
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `webconfig`
--

DROP TABLE IF EXISTS `webconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webconfig` (
  `id` int NOT NULL AUTO_INCREMENT,
  `website_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `social_links` text,
  `about_us` varchar(255) DEFAULT 'assetscontentwebconfigabout-us.html',
  `webintro` text,
  `term_policy` varchar(255) DEFAULT 'assetscontentwebconfig	erms.html',
  `video` varchar(255) DEFAULT 'https://youtu.be/I4V0QiyKAYs?si=42dQd_p4qxdpQQPX',
  `google_address` varchar(255) DEFAULT 'https://www.google.com/maps/embed?pb=YlT5hsMgMuDsumJDR2JGSghVk2XMvpvPNAYouhTcS_F_HMFwRYZpDceLqIhmfpZOqUVbjFJB8_FNYUIjPz3HnqjjkbYCnrWcVVYNm_Npp2iCHPqgEpD6AkZAyF-ly62hGeGkGxzB02eaACrJ-_Gcuu7CR9IinGtfFZcyIk7i',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webconfig`
--

LOCK TABLES `webconfig` WRITE;
/*!40000 ALTER TABLE `webconfig` DISABLE KEYS */;
INSERT INTO `webconfig` VALUES (1,'RainRenew','4269 Yen Vien\nGia Lam, Ha Noi\nViet Nam','+1 5589 55488 55','info@example.com','{\"twitter\": \"https://twitter.com/example\", \"facebook\": \"https://facebook.com/example\", \"instagram\": \"https://instagram.com/example\", \"google-plus\": \"https://plus.google.com/example\", \"linkedin\": \"https://linkedin.com/example\"}','assets/content/webconfig/about-us.html','Embrace Sustainability: Harvesting Rainwater to Nurture Our Planet\'s Future.','assets/content/webconfig/terms.html','https://youtu.be/I4V0QiyKAYs?si=42dQd_p4qxdpQQPX','https://www.google.com/maps/embed?pb=YlT5hsMgMuDsumJDR2JGSghVk2XMvpvPNAYouhTcS_F_HMFwRYZpDceLqIhmfpZOqUVbjFJB8_FNYUIjPz3HnqjjkbYCnrWcVVYNm_Npp2iCHPqgEpD6AkZAyF-ly62hGeGkGxzB02eaACrJ-_Gcuu7CR9IinGtfFZcyIk7i');
/*!40000 ALTER TABLE `webconfig` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-28 20:49:09

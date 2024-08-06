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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `substatus` tinyint(1) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `verification_expires_at` datetime DEFAULT NULL,
  `code` text,
  `user_image` varchar(255) NOT NULL DEFAULT 'assets/img/user/default-avatar.jpg',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (37,'le duc','duc12012001@gmail.com','$2y$10$hu1TtJw.kMbIgk8wRmhzfueXBQD3lZa00XtzyzSjlRlqzn.7fqnuG','yen vien','0962176285','2001-01-12',1,NULL,'2024-05-08 23:23:11','229948b51476e16d7efb6ecaa1b15f95','assets/img/user/default-avatar.jpg'),(38,'le duc','duc12012001@gmail.com','$2y$10$09TuoMDjsiYS.paorIMKEeH1zfP0CDHo.EiBTZi0NuWzJ5TTRdw.q','yen vien','1123112','2024-05-14',1,'2024-05-08 23:23:06','2024-05-08 23:25:43','','assets/img/user/default-avatar.jpg'),(39,'le duc','duc12012001@gmail.com','$2y$10$Cu0C0DzpyLg5jOTN0nQ2B.ThDkxK3.EAJiD7mgf8X1QnYigJ/YuLK','yen vien','1123112','2024-05-15',1,'2024-05-08 23:33:36','2024-05-08 23:36:07','','assets/img/user/default-avatar.jpg'),(40,'le duc','duc12012001@gmail.com','$2y$10$PyUsu7bBctdplIl3MldQ9.QauC4rrfBXuauJPBnQ7hNtk.9a.1Dg2','Yen vien','0013327123','2024-03-19',1,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(41,'le duc','leminhduc1212001@gmail.com','$2y$10$1YaLp7BJvpKR3L3ktNoiCeQo.wPTBM8H8lTFRX4drejHOH5UssJSC','Yen vien','0013327','2024-05-21',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(42,'','','$2y$10$xC6x0ncnBG7OX7VesWtU8OHydKSD03ZIrzrVxE/2fmx4ucHGn3Wpi','','0013327','2024-05-16',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(43,'admin','duc12012001@gmail.com','$2y$10$ihA/RB/mge3oER0UEVoZd.zIdT5oBkFz.VqeMgCFpp42L1BFJIOXC','Yen vien','0013327','2023-11-14',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(44,'admin','duc12012001@gmail.com','$2y$10$8SIe1bpNC5JUukqyyykwPe/RLp9qHBUWk/kV/3aiAIuG2/X2V0GDi','asfsa','0013327','2024-04-18',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(45,'admin','leminhduc1212001@gmail.com','$2y$10$149uSGVEGTWT.kGMbcyaw.gEFdfuKvPb.n.cZldhtJmEdFl2wuVoi','','','2024-02-14',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(46,'admin','duc12012001@gmail.com','$2y$10$m5awFRYbwltJroz5gOu3seKRQ2x3fOD.7oxc5.AE8JHDJT7naPa.u','Yen vien','0962176285','2010-02-01',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg'),(47,'admin','duc1212001@gmail.com','$2y$10$7t0IWxZ2y2oUJGayZ.LzPeA6STvZCyvuV0ETwbvdRhjSyfbklfXBW','Yen vien','0962176285','2013-01-12',NULL,NULL,NULL,NULL,'assets/img/user/default-avatar.jpg');
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

-- Dump completed on 2024-05-28 20:49:08

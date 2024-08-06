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
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `post_detail` text NOT NULL,
  `post_image` varchar(255) NOT NULL DEFAULT 'assets/img/post/post-default.jpg',
  `date` date DEFAULT NULL,
  `category_id` int NOT NULL,
  `approval_state` tinyint(1) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_category` (`category_id`),
  CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories_posts` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Rainwater Harvesting Systems','Rainwater harvesting is a sustainable practice that involves collecting and storing rainwater for later use','assets/content/post/post-1.html','assets/img/post/post-default.jpg','2023-12-30',1,1,'Admin'),(2,'Rain Gardens','Rain gardens are not just beautiful additions to your landscape; they are eco-friendly solutions to managing stormwater runoff','assets/content/post/post-2.html','assets/img/post/post-default.jpg','2023-11-07',1,1,'Admin'),(3,'Permeable Pavements ','Permeable Pavements: Paving the Way for Sustainable Urban Development','assets/content/post/post-3.html','assets/img/post/post-default.jpg','2023-04-07',1,1,'Admin'),(4,'Greywater Systems','Greywater Systems: Harnessing the Power of Sustainable Water Management','assets/content/post/post-4.html','assets/img/post/post-default.jpg','2023-10-09',1,1,'Admin'),(5,'Green Roofs','Green Roofs: Elevating Urban Sustainability','assets/content/post/post-5.html','assets/img/post/post-default.jpg','2023-01-24',1,1,'Admin'),(6,'Community Rainwater Management','Community Rainwater Management: A Sustainable Solution for Urban Resilience','assets/content/post/post-6.html','assets/img/post/post-default.jpg','2023-01-04',1,1,'Admin'),(7,'Smart Rainwater Harvesting Systems','Smart Rainwater Harvesting Systems: Harnessing Nature\'s Bounty','assets/content/post/post-7.html','assets/img/post/post-default.jpg','2023-11-08',2,1,'Admin'),(8,'Innovative Rainwater Collection Surfaces','nnovative Rainwater Collection Surfaces: Paving the Way to Sustainability','assets/content/post/post-8.html','assets/img/post/post-default.jpg','2023-03-28',2,1,'Admin'),(9,'Integration with Green Infrastructure','Integration with Green Infrastructure: Paving the Way to Sustainable Cities','assets/content/post/post-9.html','assets/img/post/post-default.jpg','2023-08-19',2,1,'Admin'),(10,'Community-Based Rainwater Harvesting Initiatives','Community-based rainwater harvesting initiatives are emerging as powerful tools in the fight against water scarcity and climate change','assets/content/post/post-10.html','assets/img/post/post-default.jpg','2023-06-11',2,1,'Admin'),(11,'Education and Awareness Campaigns','Education and awareness campaigns play a pivotal role in shaping societies, driving positive change, and fostering informed decision-making','assets/content/post/post-11.html','assets/img/post/post-default.jpg','2023-04-27',2,1,'Admin'),(12,'Policy Support and Incentives','Policy Support and Incentives: Fostering Sustainable Change','assets/content/post/post-12.html','assets/img/post/post-default.jpg','2023-04-06',3,1,'Admin'),(13,'Smart Rainwater Harvesting Systems','Smart Rainwater Harvesting Systems: Pioneering Sustainable Water Management','assets/content/post/post-13.html','assets/img/post/post-default.jpg','2023-05-10',3,1,'Admin'),(14,'Modular Rainwater Harvesting Tanks','Modular Rainwater Harvesting Tanks: Sustainable Solutions for Water Conservation','assets/content/post/post-14.html','assets/img/post/post-default.jpg','2023-12-29',3,1,'Admin'),(15,'Green Roofs with Rainwater Harvesting Capability','Green Roofs with Rainwater Harvesting Capability: A Sustainable Urban Solution','assets/content/post/post-15.html','assets/img/post/post-default.jpg','2023-11-24',3,1,'Admin'),(16,'Innovative Filtering Technologies','Innovative Filtering Technologies: Revolutionizing Clean Water Solutions','assets/content/post/post-16.html','assets/img/post/post-default.jpg','2023-07-06',3,1,'Admin'),(17,'Integration with Greywater Recycling','Integration with Greywater Recycling: A Sustainable Approach','assets/content/post/post-17.html','assets/img/post/post-default.jpg','2023-11-12',3,1,'Admin'),(18,'Community Rainwater Harvesting Projects','Empowering Communities: The Impact of Rainwater Harvesting Projects','assets/content/post/post-18.html','assets/img/post/post-default.jpg','2023-10-16',3,1,'Admin'),(49,'Le duc','Name test','assets/content/post/post-49.html','assets/img/post/post-1715850994.jpg','2024-05-16',1,0,'Admin User'),(50,'Le duc','Name test','assets/content/post/post-50.html','assets/img/post/post-1715851289.jpg','2024-05-16',1,0,'Admin User');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
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

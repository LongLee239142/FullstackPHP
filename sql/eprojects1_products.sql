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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `quantity` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `description_detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_category` (`category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,50.99,'assets/img/product/product-1.jpg','Rain harvesting product description',10,1,'Rain Harvesting Product 1','assets/content/product/product_default.html'),(2,35.99,'assets/img/product/product-2.jpg','Rain harvesting product description',20,2,'Rain Harvesting Product 2','assets/content/product/product_default.html'),(3,45.99,'assets/img/product/product-3.jpg','Rain harvesting product description',15,3,'Rain Harvesting Product 3','assets/content/product/product_default.html'),(4,60.99,'assets/img/product/product-4.jpg','Rain harvesting product description',8,1,'Rain Harvesting Product 4','assets/content/product/product_default.html'),(5,25.99,'assets/img/product/product-5.jpg','Rain harvesting product description',12,2,'Rain Harvesting Product 5','assets/content/product/product_default.html'),(6,45.99,'assets/img/product/product-6.jpg','Rain harvesting product description',14,2,'Rain Harvesting Product 6','assets/content/product/product_default.html'),(7,39.86,'assets/img/product/product-7.jpg','Rain harvesting product description',85,1,'Rain Harvesting Product 7','assets/content/product/product_default.html'),(8,88.63,'assets/img/product/product-8.jpg','Rain harvesting product description',15,1,'Rain Harvesting Product 8','assets/content/product/product_default.html'),(9,14,'assets/img/product/product-9.jpg','Rain harvesting product description',33,1,'Rain Harvesting Product 9','assets/content/product/product_default.html'),(10,28,'assets/img/product/product-10.jpg','Rain harvesting product description',63,1,'Rain Harvesting Product 10','assets/content/product/product_default.html'),(11,67.92,'assets/img/product/product-11.jpg','Rain harvesting product description',45,1,'Rain Harvesting Product 11','assets/content/product/product_default.html'),(12,76.14,'assets/img/product/product-12.jpg','Rain harvesting product description',13,2,'Rain Harvesting Product 12','assets/content/product/product_default.html'),(13,57.6,'assets/img/product/product-13.jpg','Rain harvesting product description',68,3,'Rain Harvesting Product 13','assets/content/product/product_default.html'),(14,52.18,'assets/img/product/product-14.jpg','Rain harvesting product description',45,3,'Rain Harvesting Product 14','assets/content/product/product_default.html');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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

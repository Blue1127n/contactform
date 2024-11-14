-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: laravel_db
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'商品のお届けについて','2024-11-04 18:37:47','2024-11-04 18:37:47'),(2,'商品の交換について','2024-11-04 18:37:47','2024-11-04 18:37:47'),(3,'商品トラブル','2024-11-04 18:37:47','2024-11-04 18:37:47'),(4,'ショップへのお問い合わせ','2024-11-04 18:37:47','2024-11-04 18:37:47'),(5,'その他','2024-11-04 18:37:47','2024-11-04 18:37:47');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_category_id_foreign` (`category_id`),
  CONSTRAINT `contacts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,1,'山田','太郎',1,'test@gmail.com','08012341245','東京都港区赤坂2-5','東京マンション101','発送時期について','2024-11-05 03:34:17','2024-11-05 03:34:17'),(2,1,'山田','太郎',1,'test@gmail.com','08012345678','東京都港区赤坂2-5','東京マンション101','発送時期について','2024-11-05 03:38:18','2024-11-05 03:38:18'),(3,1,'山田','太郎',1,'test@gmail.com','08012345678','東京都港区赤坂2-5','東京マンション101','発送時期について','2024-11-05 03:40:46','2024-11-05 03:40:46'),(4,1,'山田','太郎',1,'test@gmail.com','08012347896','東京都港区赤坂2-5','東京マンション101','発送時期について','2024-11-05 04:29:36','2024-11-05 04:29:36'),(5,1,'山田','太郎',1,'test@gmail.com','08012341234','東京都港区赤坂2-5','東京マンション101','発送時期について','2024-11-08 05:07:12','2024-11-08 05:07:12'),(6,1,'上田','一郎',1,'mit@gmail.com','09001278955','大阪市中央区南船場2-8','大阪マンション101','発送時期について','2024-11-10 07:32:31','2024-11-10 07:32:31'),(7,1,'中村','太郎',1,'po@gmail.com','07045276524','東京都世田谷区三宿1-7','世田谷マンション101','発送時期について','2024-11-10 07:34:48','2024-11-10 07:34:48'),(8,1,'中山','あい',2,'che@gmail.com','08057182378','京都府京都市中京区1-2-9','京都マンション101','発送時期について','2024-11-14 00:06:28','2024-11-14 00:06:28');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2024_11_05_021357_create_categories_table',1),(5,'2024_11_05_021500_create_users_table',1),(6,'2024_11_05_022301_create_contacts_table',1),(7,'2014_10_12_200000_add_two_factor_columns_to_users_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'山田　太郎','ere@gmail.com','$2y$10$EYvVzXsKdhCboym0gRIHQemNCZjE366JT3rodzGtx6gGb3Vqb.jP2',NULL,NULL,NULL,'2024-11-08 03:50:28','2024-11-08 03:50:28'),(2,'山田　太郎','test@gmail.com','$2y$10$vcnk3WP1oey.rdfTFNkYEOlp72u.2ds4EgTo/wtX3ABt5T61h3x32',NULL,NULL,NULL,'2024-11-08 09:53:55','2024-11-08 09:53:55'),(3,'山田　太郎','tes@gmail.com','$2y$10$jLbUaOK35S02WzFWUEg6.uwulbwmss.VcfyVsQl51VKQoAqn55pE.',NULL,NULL,NULL,'2024-11-08 10:23:29','2024-11-08 10:23:29'),(5,'山田　次郎','edmi@gmail.com','$2y$10$GOE/ZCZQBHL9zkBSR7tzYeNyMmNcTdDl7/9A1sGmH5ylnCxeQz3Ai',NULL,NULL,NULL,'2024-11-08 12:05:54','2024-11-08 12:05:54'),(6,'足立　里香','dree@gmail.com','$2y$10$cOtk35LSSzxIjk6sb9TL8eaHR9/KEazIRiKdYerV0Lp6E9ddY3pGm',NULL,NULL,NULL,'2024-11-08 12:11:59','2024-11-08 12:11:59'),(7,'山口　博','tte@gmail.com','$2y$10$DH.ldVeMnpsA2yuC9vsxPO3Z0yMkwPL6gsCiTsqyvdIwb7nqFP98u',NULL,NULL,NULL,'2024-11-08 12:21:34','2024-11-08 12:21:34'),(8,'田村　孝','cesyy@docomo.ne.jp','$2y$10$QQT.BX6.VfrnLOHeqT3bEe0q4sFtk09p3L/pcGkfz.Ll3sZzCFi72',NULL,NULL,NULL,'2024-11-08 12:26:46','2024-11-08 12:26:46'),(9,'出口　入口','bebu@gmail.com','$2y$10$MSrmOi2S8tCyAS4sMB/Dh.z8asxxMZP1/saHCx2kTrq2Zv7WXu6pm',NULL,NULL,NULL,'2024-11-08 12:36:17','2024-11-08 12:36:17'),(10,'安藤　ありさ','mec@gmail.com','$2y$10$NCxl09kWR79uGXQyoZ0/yuVR8gR2C86D7zCY1xtSWi2p5nSynZQ6W',NULL,NULL,NULL,'2024-11-08 12:42:17','2024-11-08 12:42:17'),(11,'上田　つよし','wec@gmail.com','$2y$10$5H/TR.Fw2wBlWCUqRvMI6e3VVorL3h/4XxRbBIpCjDRrOOtSjy2pK',NULL,NULL,NULL,'2024-11-10 00:34:12','2024-11-10 00:34:12'),(12,'中村　ひとし','wec1@gmail.com','$2y$10$s1RKJPTrcZ34VXYEsbSfDOUxVtZd3gMnu.DJciU7e46LPxGYeghZu',NULL,NULL,NULL,'2024-11-10 00:40:16','2024-11-10 00:40:16'),(13,'前田　幸太郎','kou@gmail.com','$2y$10$WvrpGLE6gZ7UoOlru1nwd.ni/Nyi5SbGbfMk1rPRsEPMIR33ztkeG',NULL,NULL,NULL,'2024-11-10 07:36:59','2024-11-10 07:36:59');
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

-- Dump completed on 2024-11-14  8:13:25

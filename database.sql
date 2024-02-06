-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bbib_crud
DROP DATABASE IF EXISTS `bbib_crud`;
CREATE DATABASE IF NOT EXISTS `bbib_crud` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bbib_crud`;

-- Dumping structure for table bbib_crud.animal_medicine
DROP TABLE IF EXISTS `animal_medicine`;
CREATE TABLE IF NOT EXISTS `animal_medicine` (
  `id` varchar(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `medication_name` varchar(255) DEFAULT NULL,
  `medication_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `usage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `batch_number` varchar(50) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `contradictions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `stock` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data obat-obatan ternak';

-- Data exporting was unselected.

-- Dumping structure for table bbib_crud.medication_retrieval
DROP TABLE IF EXISTS `medication_retrieval`;
CREATE TABLE IF NOT EXISTS `medication_retrieval` (
  `id` varchar(36) NOT NULL,
  `retrieval_date` date DEFAULT NULL,
  `taken_by` int NOT NULL,
  `quantity_taken` bigint DEFAULT NULL,
  `evidence` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taken_by` (`taken_by`),
  CONSTRAINT `medication_retrieval_ibfk_1` FOREIGN KEY (`id`) REFERENCES `animal_medicine` (`id`),
  CONSTRAINT `medication_retrieval_ibfk_2` FOREIGN KEY (`taken_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data pengambilan obat-obatan ternak';

-- Data exporting was unselected.

-- Dumping structure for table bbib_crud.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL DEFAULT 'Administrator',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Role user and reference into user';

-- Data exporting was unselected.

-- Dumping structure for table bbib_crud.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` longtext,
  `role` int unsigned NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `constraint_users_to_roles` (`role`),
  CONSTRAINT `constraint_users_to_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data karyawan dan pengguna';

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

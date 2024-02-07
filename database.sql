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

-- Dumping data for table bbib_crud.animal_medicine: ~0 rows (approximately)
DELETE FROM `animal_medicine`;

-- Dumping structure for table bbib_crud.farms
DROP TABLE IF EXISTS `farms`;
CREATE TABLE IF NOT EXISTS `farms` (
  `id` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(191) DEFAULT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `farm_shed` varchar(191) NOT NULL,
  `entrance_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('terjual','mati','hidup') DEFAULT 'hidup',
  `pic` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `farms_category_relation` (`category`),
  KEY `farms_users_relation` (`pic`),
  CONSTRAINT `farms_category_relation` FOREIGN KEY (`category`) REFERENCES `farm_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `farms_users_relation` FOREIGN KEY (`pic`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data hewan ternak';

-- Dumping data for table bbib_crud.farms: ~0 rows (approximately)
DELETE FROM `farms`;

-- Dumping structure for table bbib_crud.farm_category
DROP TABLE IF EXISTS `farm_category`;
CREATE TABLE IF NOT EXISTS `farm_category` (
  `id` varchar(36) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_name` varchar(191) NOT NULL,
  `color` varchar(191) NOT NULL DEFAULT '#fff',
  `weight_class` enum('berat','sedang','ringan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'ringan',
  `race` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table bbib_crud.farm_category: ~0 rows (approximately)
DELETE FROM `farm_category`;

-- Dumping structure for table bbib_crud.medication_retrieval
DROP TABLE IF EXISTS `medication_retrieval`;
CREATE TABLE IF NOT EXISTS `medication_retrieval` (
  `id` varchar(36) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `retrieval_date` date DEFAULT NULL,
  `med_id` varchar(36) NOT NULL,
  `taken_by` int NOT NULL,
  `quantity_taken` bigint unsigned DEFAULT '0',
  `evidence` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taken_by` (`taken_by`),
  KEY `medication_retrieval_ibfk_1` (`med_id`),
  CONSTRAINT `medication_retrieval_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `animal_medicine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medication_retrieval_ibfk_2` FOREIGN KEY (`taken_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data pengambilan obat-obatan ternak';

-- Dumping data for table bbib_crud.medication_retrieval: ~0 rows (approximately)
DELETE FROM `medication_retrieval`;

-- Dumping structure for table bbib_crud.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL DEFAULT 'Administrator',
  `color` varchar(9) DEFAULT '#FFFFFF',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Role user and reference into user';

-- Dumping data for table bbib_crud.roles: ~2 rows (approximately)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `color`) VALUES
	(1, 'Administrator', '#ea6213'),
	(2, 'Karyawan', '#EBD2A9');

-- Dumping structure for table bbib_crud.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` longtext,
  `role` int unsigned NOT NULL,
  `phone` char(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_phone` (`phone`),
  KEY `constraint_users_to_roles` (`role`),
  CONSTRAINT `constraint_users_to_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Data karyawan dan pengguna';

-- Dumping data for table bbib_crud.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `created_at`, `updated_at`, `full_name`, `address`, `role`, `phone`, `email`, `password`, `remember_token`) VALUES
	(1, '2024-02-06 11:48:28', '2024-02-06 17:39:56', 'System Administrator', 'Jl. BBIB No.1, Ds. Toyomarto,Kec. Singosari, Malang 65153\r\nJawa Timur Indonesia', 1, '+6285895679267', 'bbib.singosari@pertanian.go.id', '$2a$12$23hZ.8hmVw07XOS80BgoDevV3QpBJu0o78ckY6ZotTScdTKcF5Ja.', '08274ff31a7fe3e3dd9f74841cb1a343a87a75706b0671e749bd72994bf37664955731903a232cf15d4044afa02a3fa2ac91fa1caf4f84c7043a76bff8fde9b9');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

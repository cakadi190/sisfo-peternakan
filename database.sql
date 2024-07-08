-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2024 at 03:53 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbib_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `animal_medicines`
--

CREATE TABLE `animal_medicines` (
  `id` varchar(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `medication_name` varchar(255) DEFAULT NULL,
  `medication_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `usage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `batch_number` varchar(50) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `buy_date` date DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `contradictions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `stock` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data obat-obatan ternak';

-- --------------------------------------------------------

--
-- Table structure for table `barn_categories`
--

CREATE TABLE `barn_categories` (
  `id` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `barn_name` varchar(191) DEFAULT 'CURRENT_TIMESTAMP',
  `description` longtext,
  `vendor` enum('local','outside') DEFAULT 'local',
  `vendor_name` varchar(191) DEFAULT NULL,
  `stock` bigint DEFAULT '0',
  `entrance_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Komoditas gudang bahan pakan ternak';

-- --------------------------------------------------------

--
-- Table structure for table `barn_retrievals`
--

CREATE TABLE `barn_retrievals` (
  `id` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categories` varchar(191) NOT NULL,
  `retrieval_date` date DEFAULT NULL,
  `taken_by` int DEFAULT NULL,
  `quantity_taken` bigint UNSIGNED DEFAULT '0',
  `evidence` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data pengambilan stok pakan';

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE `farms` (
  `id` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(191) DEFAULT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `farm_shed` varchar(191) NOT NULL,
  `entrance_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('terjual','mati','hidup') DEFAULT 'hidup',
  `pic` int DEFAULT NULL,
  `gender` enum('jantan','betina') DEFAULT 'jantan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data hewan ternak';

-- --------------------------------------------------------

--
-- Table structure for table `farm_category`
--

CREATE TABLE `farm_category` (
  `id` varchar(36) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_name` varchar(191) NOT NULL,
  `color` varchar(191) NOT NULL DEFAULT '#fff',
  `weight_class` enum('berat','sedang','ringan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'ringan',
  `race` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Kategori hewan ternak';

-- --------------------------------------------------------

--
-- Table structure for table `medication_retrieval`
--

CREATE TABLE `medication_retrieval` (
  `id` varchar(36) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `retrieval_date` date DEFAULT NULL,
  `med_id` varchar(36) NOT NULL,
  `taken_by` int NOT NULL,
  `quantity_taken` bigint UNSIGNED DEFAULT '0',
  `evidence` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data pengambilan obat-obatan ternak';

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL DEFAULT 'Administrator',
  `color` varchar(9) DEFAULT '#FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Role user and reference into user';

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `color`) VALUES
(1, 'Administrator', '#ea6213'),
(2, 'Karyawan', '#EBD2A9');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` longtext,
  `role` int UNSIGNED NOT NULL,
  `phone` char(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data karyawan dan pengguna';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `full_name`, `address`, `role`, `phone`, `email`, `password`, `remember_token`) VALUES
(1, '2024-02-06 04:48:28', '2024-07-08 15:49:39', 'System Administrator', 'Jl. BBIB No.1, Ds. Toyomarto,Kec. Singosari, Malang 65153\r\nJawa Timur Indonesia', 1, '+6285895679267', 'bbib.singosari@pertanian.go.id', '$2a$12$kIf9Q/evkBvhlQNhvRz6Uewbtc/EfKphYLpRXwOZwJiOLpWYgOR.q', '8a29c5191c4f62f0cd2d586aa2197122452a2bf1dd0fd9f494f147fae25628a60d40cee3284e08a16a0cdececbce1a9f6bdef2fbb98d348501a9721894eb972a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal_medicines`
--
ALTER TABLE `animal_medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barn_categories`
--
ALTER TABLE `barn_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barn_retrievals`
--
ALTER TABLE `barn_retrievals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_constraint_barnstocks` (`taken_by`),
  ADD KEY `categories_constraint_barnstocks` (`categories`);

--
-- Indexes for table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `farms_category_relation` (`category`),
  ADD KEY `farms_users_relation` (`pic`);

--
-- Indexes for table `farm_category`
--
ALTER TABLE `farm_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medication_retrieval`
--
ALTER TABLE `medication_retrieval`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taken_by` (`taken_by`),
  ADD KEY `medication_retrieval_ibfk_1` (`med_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_phone` (`phone`),
  ADD KEY `constraint_users_to_roles` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barn_retrievals`
--
ALTER TABLE `barn_retrievals`
  ADD CONSTRAINT `categories_constraint_barnstocks` FOREIGN KEY (`categories`) REFERENCES `barn_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_constraint_barnstocks` FOREIGN KEY (`taken_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `farms_category_relation` FOREIGN KEY (`category`) REFERENCES `farm_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `farms_users_relation` FOREIGN KEY (`pic`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medication_retrieval`
--
ALTER TABLE `medication_retrieval`
  ADD CONSTRAINT `medication_retrieval_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `animal_medicines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medication_retrieval_ibfk_2` FOREIGN KEY (`taken_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `constraint_users_to_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 12:31 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courierboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `phone` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `status`, `phone`, `username`, `email_verified_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$12$COA4ClPe.M3pNsxG3OCsJuFumoFqamyh4WHqPjpoF5kQo/59QuHEq', 1, '4567812345', 'admin@gmail.com', '2023-11-08 07:37:59', NULL, NULL, '2023-11-08 07:37:59', '2023-11-08 07:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `company_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: courier company, 1: others',
  `website` varchar(255) DEFAULT NULL,
  `drivers` int(11) NOT NULL,
  `mc_number` varchar(255) DEFAULT NULL,
  `dot_number` varchar(255) DEFAULT NULL,
  `insurance_name` varchar(255) NOT NULL,
  `gen_insurance` varchar(255) NOT NULL,
  `cargo_insurance` varchar(255) NOT NULL,
  `other_insurance` varchar(255) DEFAULT NULL,
  `declaration` varchar(255) DEFAULT NULL,
  `contact_fname` varchar(255) NOT NULL,
  `contact_lname` varchar(255) NOT NULL,
  `contact_title` varchar(255) NOT NULL,
  `company_phone` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 : inactive, 1 : active',
  `other1` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `other3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `address1`, `address2`, `city`, `state`, `country`, `zip`, `company_type`, `website`, `drivers`, `mc_number`, `dot_number`, `insurance_name`, `gen_insurance`, `cargo_insurance`, `other_insurance`, `declaration`, `contact_fname`, `contact_lname`, `contact_title`, `company_phone`, `mobile`, `email`, `password`, `username`, `status`, `other1`, `other2`, `other3`, `created_at`, `updated_at`) VALUES
(3, 'Laxmi Chit Fund', '13 Worcestshire Road', 'Bradford Av', 'London', 'England', 'United Kingdom', '54792', 0, 'laxmichitfund.com', 67, '43167', NULL, 'Laxmi Chit Fund', '876543', '6543', '76542', '1699442672.jpg', 'John', 'Doe', 'CEO', '912538211', '912538211', 'jabibov534@glalen.com', '$2y$12$H/5XB4EvqYaMjdonxQZ2Ve2Cwr.y8H2rRhmgDdj3h0SFFpyPi9bb6', 'jabibov534@glalen.com', 1, NULL, NULL, NULL, '2023-11-08 06:24:32', '2023-11-08 06:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_11_03_113848_create_users_table', 1),
(4, '2023_11_07_090204_create_couriers_table', 1),
(5, '2023_11_07_091551_create_quote_requests_table', 1),
(6, '2023_11_07_095048_create_payment_cards_table', 1),
(7, '2023_11_07_111807_create_quote_responses_table', 1),
(8, '2023_11_08_100138_add_dot_number_column_to_couriers_table', 2),
(9, '2023_11_08_120425_create_admins_table', 3),
(11, '2023_11_08_132729_add_columns_to_requests_table', 4),
(12, '2023_11_09_092800_add_columns_to_requests_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `payment_cards`
--

CREATE TABLE `payment_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 : User, 1 : Courier',
  `owner_id` bigint(20) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `zip` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `cvv` varchar(255) NOT NULL,
  `expiry` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 : inactive, 1 : active',
  `other1` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup` date NOT NULL,
  `start_point` varchar(255) NOT NULL,
  `delivery_point` varchar(255) NOT NULL,
  `mileage` varchar(255) DEFAULT NULL,
  `pickup_time` time NOT NULL,
  `delivery_time` time NOT NULL,
  `weight` double(8,2) NOT NULL,
  `dimensions` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `vehicle_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 - any, 1 - car, 2 - minivan, 3 - suv, 4  - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer',
  `reefer` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 : yes, 1 : no',
  `hazmat` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 : yes, 1 : no',
  `lift_gate` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 : yes, 1 : no',
  `sender_name` varchar(255) NOT NULL,
  `sender_phone` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `courier_id` bigint(20) DEFAULT NULL,
  `quote_id` bigint(20) DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 : listed, 1 : bid , 2 : accepted 3 : completed, 4: removed',
  `other1` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `other3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pickup_address1` varchar(255) DEFAULT NULL,
  `pickup_address2` varchar(255) DEFAULT NULL,
  `pickup_city` varchar(255) DEFAULT NULL,
  `pickup_state` varchar(255) DEFAULT NULL,
  `pickup_company` varchar(255) DEFAULT NULL,
  `delivery_address1` varchar(255) DEFAULT NULL,
  `delivery_address2` varchar(255) DEFAULT NULL,
  `delivery_city` varchar(255) DEFAULT NULL,
  `delivery_state` varchar(255) DEFAULT NULL,
  `delivery_company` varchar(255) DEFAULT NULL,
  `delivery_name` varchar(255) DEFAULT NULL,
  `delivery_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `pickup`, `start_point`, `delivery_point`, `mileage`, `pickup_time`, `delivery_time`, `weight`, `dimensions`, `description`, `vehicle_type`, `reefer`, `hazmat`, `lift_gate`, `sender_name`, `sender_phone`, `sender_email`, `user_id`, `courier_id`, `quote_id`, `transaction_id`, `status`, `other1`, `other2`, `other3`, `created_at`, `updated_at`, `pickup_address1`, `pickup_address2`, `pickup_city`, `pickup_state`, `pickup_company`, `delivery_address1`, `delivery_address2`, `delivery_city`, `delivery_state`, `delivery_company`, `delivery_name`, `delivery_phone`) VALUES
(5, '2023-12-12', '23450', '14591', '566 mi', '16:00:00', '13:00:00', 4.50, '12x12x12 inches', 'Long White Steel Rod', 0, 1, 1, 1, 'Muhammad Arslan', '3418710911', 'gecepa1867@glalen.com', 16, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2023-11-09 05:17:56', '2023-11-09 05:17:56', NULL, 'Virginia Beach, VA 23450, USA', 'Virginia Beach', 'Virginia', NULL, NULL, 'Wyoming, NY 14591, USA', 'Wyoming', 'New York', NULL, NULL, NULL),
(8, '2023-12-13', '23455', '14512', '528 mi', '16:00:00', '16:00:00', 45.00, '12x12x12 ft', 'Radio-active Waste', 0, 0, 1, 0, 'Muhammad Haris', '7163241919', 'mharis@outlook.com', 16, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2023-11-09 05:34:27', '2023-11-09 06:25:33', '1270 Diamond Springs Rd #109', 'Virginia Beach, VA 23455, USA', 'Virginia Beach', 'Virginia', 'NA', '151 S Main St', 'Naples, NY 14512, USA', 'Naples', 'New York', 'NA', 'John Doe', '7163241919');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mail_address_1` varchar(255) DEFAULT NULL,
  `mail_address_2` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Shipper 1: 3rd Party 2: Freight 3: Courier',
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `alert_email_1` varchar(255) DEFAULT NULL,
  `alert_email_2` varchar(255) DEFAULT NULL,
  `alert_freight` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: yes , 1: no',
  `alert_vehicle` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: yes , 1: no',
  `alert_rpf` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: yes , 1: no',
  `alert_driver` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: yes , 1: no',
  `account_no` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `other1` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `other3` varchar(255) DEFAULT NULL,
  `other4` varchar(255) DEFAULT NULL,
  `other5` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `phone`, `fax`, `email`, `email_verified_at`, `password`, `mail_address_1`, `mail_address_2`, `company`, `company_type`, `city`, `state`, `country`, `zip`, `status`, `alert_email_1`, `alert_email_2`, `alert_freight`, `alert_vehicle`, `alert_rpf`, `alert_driver`, `account_no`, `title`, `phone_verified_at`, `username`, `other1`, `other2`, `other3`, `other4`, `other5`, `created_at`, `updated_at`) VALUES
(14, 'Caleb', 'Altair', '3418710917', '3418710918', 'calebjanaltair@gmail.com', NULL, '$2y$12$FtQNAE84vmwokAZuatRwtus7WKJdOU.ZdfCZIlVyXmh49T22fqSfa', '13 Baker Street', '14 Baker Street', 'NA', 4, 'Poughkeepsie', 'Wyoming', 'United States of America', '47628', 1, 'calebjanaltair@gmail.com', NULL, 1, 1, 1, 1, '124914', 'CEO', NULL, 'calebjanaltair@gmail.com', NULL, NULL, NULL, NULL, NULL, '2023-11-09 04:57:25', '2023-11-09 04:57:25'),
(16, 'Muhammad', 'Arslan', '3418710911', '3418710911', 'gecepa1867@glalen.com', NULL, '$2y$12$cO4R9qCtPiwZ4rxENkqK2.pEr4M3haOmoIjjJzd8Wg1Na9sJPxt/q', 'Phase-1 Nadirabad, Lahore, Punjab 54792, Pakistan', NULL, 'NA', 0, 'Lahore', 'Punjab', 'Pakistan', '54792', 1, 'gecepa1867@glalen.com', NULL, 1, 1, 1, 1, '891337', NULL, NULL, 'gecepa1867@glalen.com', NULL, NULL, NULL, NULL, NULL, '2023-11-09 05:17:52', '2023-11-09 05:17:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_cards`
--
ALTER TABLE `payment_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_fax_unique` (`fax`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_cards`
--
ALTER TABLE `payment_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

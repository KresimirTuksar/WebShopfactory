-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2024 at 05:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `description`) VALUES
(48, 'Power Tools', NULL, 'Electric and battery-powered tools for various applications.'),
(49, 'Hand Tools', NULL, 'Manual tools for construction, repair, and maintenance.'),
(50, 'Garden Tools', NULL, 'Tools for gardening and outdoor maintenance.'),
(51, 'Plumbing', NULL, 'Plumbing supplies and tools for installations and repairs.'),
(52, 'Electrical', NULL, 'Electrical components and tools for wiring and repairs.'),
(53, 'Building Materials', NULL, 'Materials used in construction and renovation projects.'),
(54, 'Hardware', NULL, 'Various hardware items such as screws, nails, and bolts.'),
(55, 'Safety Gear', NULL, 'Protective equipment for safety and health during work.'),
(56, 'Paints and Finishes', NULL, 'Products for painting and finishing surfaces.');

-- --------------------------------------------------------

--
-- Table structure for table `contractlists`
--

CREATE TABLE `contractlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractlists`
--

INSERT INTO `contractlists` (`id`, `user_id`, `product_sku`, `price`) VALUES
(10, 15, 'CEM46724', 180.00),
(11, 15, 'PIP71161', 442.00),
(12, 13, 'DRY43131', 404.00),
(13, 13, 'PRO93982', 734.00);

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(4, '2024_08_31_171601_create_products_table', 1),
(68, '0001_01_01_000000_create_users_table', 2),
(69, '0001_01_01_000001_create_cache_table', 2),
(70, '0001_01_01_000002_create_jobs_table', 2),
(71, '2024_08_31_172745_create_products_table', 2),
(72, '2024_08_31_172845_create_categories_table', 2),
(73, '2024_08_31_173136_create_product_categories_table', 2),
(74, '2024_08_31_173249_create_pricelists_table', 2),
(75, '2024_08_31_173353_create_product_pricelists_table', 2),
(76, '2024_08_31_173354_create_contractlists_table', 2),
(77, '2024_08_31_173355_create_orders_table', 2),
(78, '2024_08_31_173355_create_product_orders_table', 2),
(79, '2024_08_31_174018_create_order_meta_table', 2),
(80, '2024_08_31_175442_add_details_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `tax_amount`, `discount_amount`, `total_amount`) VALUES
(8, 12, 270.00, 67.50, 27.00, 310.50),
(10, 12, 270.00, 67.50, 27.00, 310.50),
(11, 12, 270.00, 67.50, 27.00, 310.50),
(12, 12, 520.00, 130.00, 52.00, 598.00),
(13, 12, 85.00, 21.25, 0.00, 106.25),
(14, 12, 85.00, 21.25, 10.63, 95.63);

-- --------------------------------------------------------

--
-- Table structure for table `order_meta`
--

CREATE TABLE `order_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_meta`
--

INSERT INTO `order_meta` (`id`, `order_id`, `meta_key`, `meta_value`) VALUES
(32, 8, 'customer_name', 'John Doe'),
(33, 8, 'customer_email', 'john.doe@example.com'),
(34, 8, 'customer_phone', '123-456-7890'),
(35, 8, 'customer_address', '123 Main St'),
(36, 8, 'customer_city', 'Springfield'),
(37, 8, 'customer_country', 'USA'),
(44, 10, 'customer_name', 'John Doe'),
(45, 10, 'customer_email', 'john.doe@example.com'),
(46, 10, 'customer_phone', '123-456-7890'),
(47, 10, 'customer_address', '123 Main St'),
(48, 10, 'customer_city', 'Springfield'),
(49, 10, 'customer_country', 'USA'),
(50, 11, 'customer_name', 'John Doe'),
(51, 11, 'customer_email', 'john.doe@example.com'),
(52, 11, 'customer_phone', '123-456-7890'),
(53, 11, 'customer_address', '123 Main St'),
(54, 11, 'customer_city', 'Springfield'),
(55, 11, 'customer_country', 'USA'),
(56, 12, 'customer_name', 'John Doe'),
(57, 12, 'customer_email', 'john.doe@example.com'),
(58, 12, 'customer_phone', '123-456-7890'),
(59, 12, 'customer_address', '123 Main St'),
(60, 12, 'customer_city', 'Springfield'),
(61, 12, 'customer_country', 'USA'),
(62, 13, 'customer_name', 'John Doe'),
(63, 13, 'customer_email', 'john.doe@example.com'),
(64, 13, 'customer_phone', '123-456-7890'),
(65, 13, 'customer_address', '123 Main St'),
(66, 13, 'customer_city', 'Springfield'),
(67, 13, 'customer_country', 'USA'),
(68, 14, 'customer_name', 'John Doe'),
(69, 14, 'customer_email', 'john.doe@example.com'),
(70, 14, 'customer_phone', '123-456-7890'),
(71, 14, 'customer_address', '123 Main St'),
(72, 14, 'customer_city', 'Springfield'),
(73, 14, 'customer_country', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricelists`
--

CREATE TABLE `pricelists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricelists`
--

INSERT INTO `pricelists` (`id`, `name`) VALUES
(26, 'Retail'),
(27, 'Wholesale'),
(28, 'Distributor'),
(29, 'Reseller');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `price`, `published`) VALUES
(651, 'COR24547', 'Cordless Drill', 120.00, 1),
(652, 'HAM42807', 'Hammer Drill', 150.00, 1),
(653, 'IMP58966', 'Impact Wrench', 180.00, 1),
(654, 'SCR87657', 'Screwdriver Set', 25.00, 1),
(655, 'ADJ81253', 'Adjustable Wrench', 30.00, 1),
(656, 'HAM81077', 'Hammer', 40.00, 1),
(657, 'GAR96880', 'Garden Shears', 35.00, 1),
(658, 'LAW13880', 'Lawn Mower', 220.00, 1),
(659, 'RAK46488', 'Rake', 15.00, 1),
(660, 'PIP71161', 'Pipe Wrench', 45.00, 1),
(661, 'PLU71465', 'Plumbing Tape', 5.00, 1),
(662, 'PIP18323', 'Pipe Cutter', 50.00, 1),
(663, 'WIR52053', 'Wire Strippers', 20.00, 1),
(664, 'MUL82186', 'Multimeter', 70.00, 1),
(665, 'EXT10956', 'Extension Cord', 25.00, 1),
(666, 'DRY43131', 'Drywall Sheet', 12.00, 1),
(667, 'CEM46724', 'Cement Bag', 10.00, 1),
(668, 'CON95084', 'Concrete Mixer', 300.00, 1),
(669, 'SCR76139', 'Screws Assortment', 10.00, 1),
(670, 'NAI85047', 'Nails Assortment', 12.00, 1),
(671, 'BOL56316', 'Bolts and Nuts', 15.00, 1),
(672, 'SAF80481', 'Safety Goggles', 20.00, 1),
(673, 'PRO93982', 'Protective Gloves', 15.00, 1),
(674, 'HAR20849', 'Hard Hat', 30.00, 1),
(675, 'INT64948', 'Interior Paint', 25.00, 1),
(676, 'EXT10730', 'Exterior Paint', 30.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(90, 'COR24547', 48),
(91, 'HAM42807', 48),
(92, 'IMP58966', 48),
(93, 'SCR87657', 49),
(94, 'ADJ81253', 49),
(95, 'HAM81077', 49),
(96, 'GAR96880', 50),
(97, 'LAW13880', 50),
(98, 'RAK46488', 50),
(99, 'PIP71161', 51),
(100, 'PLU71465', 51),
(101, 'PIP18323', 51),
(102, 'WIR52053', 52),
(103, 'MUL82186', 52),
(104, 'EXT10956', 52),
(105, 'DRY43131', 53),
(106, 'CEM46724', 53),
(107, 'CON95084', 53),
(108, 'SCR76139', 54),
(109, 'NAI85047', 54),
(110, 'BOL56316', 54),
(111, 'SAF80481', 55),
(112, 'PRO93982', 55),
(113, 'HAR20849', 55),
(114, 'INT64948', 56),
(115, 'EXT10730', 56);

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `order_id`, `product_sku`, `quantity`, `unit_price`) VALUES
(2, 8, 'EXT10956', 2, 25.00),
(3, 8, 'LAW13880', 1, 220.00),
(4, 10, 'EXT10956', 2, 25.00),
(5, 10, 'LAW13880', 1, 220.00),
(6, 11, 'EXT10956', 2, 25.00),
(7, 11, 'LAW13880', 1, 220.00),
(8, 12, 'EXT10956', 12, 25.00),
(9, 12, 'LAW13880', 1, 220.00),
(10, 13, 'HAM81077', 1, 40.00),
(11, 13, 'PIP71161', 1, 45.00),
(12, 14, 'HAM81077', 1, 40.00),
(13, 14, 'PIP71161', 1, 45.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_pricelist`
--

CREATE TABLE `product_pricelist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `pricelist_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_pricelist`
--

INSERT INTO `product_pricelist` (`id`, `product_sku`, `pricelist_id`, `price`) VALUES
(112, 'HAM42807', 26, 61.00),
(113, 'NAI85047', 26, 216.00),
(114, 'SCR76139', 28, 11.00),
(115, 'COR24547', 26, 195.00),
(116, 'HAR20849', 27, 374.00),
(117, 'INT64948', 26, 104.00),
(118, 'EXT10956', 27, 370.00),
(119, 'PIP18323', 29, 363.00),
(120, 'SCR76139', 29, 338.00),
(121, 'WIR52053', 28, 393.00),
(122, 'BOL56316', 26, 227.00),
(123, 'BOL56316', 28, 141.00),
(124, 'BOL56316', 27, 176.00),
(125, 'SCR87657', 26, 218.00),
(126, 'RAK46488', 27, 215.00),
(127, 'PIP18323', 29, 278.00),
(128, 'PRO93982', 26, 211.00),
(129, 'HAM81077', 29, 132.00),
(130, 'IMP58966', 26, 113.00),
(131, 'WIR52053', 26, 92.00);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TYLqfAMGZoGqPIyhd3pKjJh8Yp8EsvIVFXqvGjgx', NULL, '127.0.0.1', 'insomnia/9.3.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0R1RHBraTRwVWlwemtmV1hXRnpicEJ1c0dZWXBsUVpYc2YwMEJSSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1725561314);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pricelist_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pricelist_id`, `name`, `email`, `phone`, `address`, `city`, `country`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 26, 'John Doe', 'john.doe@example.com', '123-456-7890', '123 Main St', 'Springfield', 'USA', NULL, '$2y$12$wPOWHRuj7a8cV44GTjfT5.RWSZ.ieIXREenqMRDQ/wKDD.gzt./3a', NULL, NULL, NULL),
(13, 27, 'Jane Smith', 'jane.smith@example.com', '234-567-8901', '456 Elm St', 'Shelbyville', 'USA', NULL, '$2y$12$d2h6hrhJnIM5T1N2ngSsae4.ATX8FC6Le4EBn6KFqxPh.4.NzKmhi', NULL, NULL, NULL),
(14, 28, 'Alice Johnson', 'alice.johnson@example.com', '345-678-9012', '789 Oak St', 'Capital City', 'USA', NULL, '$2y$12$XrXMH3hArXkr.ZNPlzhDu.QWLbEepxQtVSjCHqxJAM04gKz2dKHmu', NULL, NULL, NULL),
(15, NULL, 'Bob Brown', 'bob.brown@example.com', '456-789-0123', '321 Pine St', 'Metropolis', 'USA', NULL, '$2y$12$Y5BOwiLO8liotw0XewnWy.85iAd4V0NCdmQT.2dhfzCzM4.jwi07O', NULL, NULL, NULL),
(16, NULL, 'Charlie Green', 'charlie.green@example.com', '567-890-1234', '654 Maple St', 'Gotham', 'USA', NULL, '$2y$12$.F7LBV74gutkiTfULMMFRe0M2Jo2kb8Zl.XWRNWh7rfxxXxsOAxQi', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contractlists`
--
ALTER TABLE `contractlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractlists_user_id_foreign` (`user_id`),
  ADD KEY `contractlists_product_sku_foreign` (`product_sku`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_meta`
--
ALTER TABLE `order_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_meta_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pricelists`
--
ALTER TABLE `pricelists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_name_unique` (`name`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_product_id_foreign` (`product_id`),
  ADD KEY `product_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_orders_order_id_foreign` (`order_id`),
  ADD KEY `product_orders_product_sku_foreign` (`product_sku`);

--
-- Indexes for table `product_pricelist`
--
ALTER TABLE `product_pricelist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_pricelist_product_sku_foreign` (`product_sku`),
  ADD KEY `product_pricelist_pricelist_id_foreign` (`pricelist_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_pricelist_id_foreign` (`pricelist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `contractlists`
--
ALTER TABLE `contractlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_meta`
--
ALTER TABLE `order_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `pricelists`
--
ALTER TABLE `pricelists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=677;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_pricelist`
--
ALTER TABLE `product_pricelist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contractlists`
--
ALTER TABLE `contractlists`
  ADD CONSTRAINT `contractlists_product_sku_foreign` FOREIGN KEY (`product_sku`) REFERENCES `products` (`sku`) ON DELETE CASCADE,
  ADD CONSTRAINT `contractlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_meta`
--
ALTER TABLE `order_meta`
  ADD CONSTRAINT `order_meta_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`sku`) ON DELETE CASCADE;

--
-- Constraints for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `product_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_orders_product_sku_foreign` FOREIGN KEY (`product_sku`) REFERENCES `products` (`sku`) ON DELETE CASCADE;

--
-- Constraints for table `product_pricelist`
--
ALTER TABLE `product_pricelist`
  ADD CONSTRAINT `product_pricelist_pricelist_id_foreign` FOREIGN KEY (`pricelist_id`) REFERENCES `pricelists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_pricelist_product_sku_foreign` FOREIGN KEY (`product_sku`) REFERENCES `products` (`sku`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_pricelist_id_foreign` FOREIGN KEY (`pricelist_id`) REFERENCES `pricelists` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

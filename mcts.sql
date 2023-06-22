-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2023 at 07:57 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcts`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `user`, `status`, `created_at`, `updated_at`) VALUES
(2, 'dev-945g', '12', 1, '2023-03-20 13:27:15', '2023-03-20 13:48:14'),
(3, 'dev-034ty', '3', 1, '2023-03-20 14:11:36', '2023-03-29 04:44:21'),
(5, 'dev-747jh', '12', 1, '2023-03-20 14:29:58', '2023-04-21 06:34:58'),
(6, 'dev-898ht', '3', 1, '2023-03-28 10:10:25', '2023-04-21 06:33:14'),
(7, 'KK-834', '13', 1, '2023-04-20 12:31:31', '2023-04-20 12:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geo_fences`
--

CREATE TABLE `geo_fences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coordinates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`coordinates`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `geo_fences`
--

INSERT INTO `geo_fences` (`id`, `device_id`, `coordinates`, `created_at`, `updated_at`) VALUES
(14, '6', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[32.544427,0.384656],[32.544427,0.384656],[32.563989,0.393582],[32.563989,0.393582],[32.567421,0.379163],[32.567421,0.379163],[32.547859,0.371953],[32.547859,0.371953],[32.544256,0.385514],[32.544427,0.384656]]]}}', '2023-04-26 13:34:11', '2023-04-26 13:34:11'),
(26, '5', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[32.548891,0.340265],[32.548891,0.340265],[32.561245,0.354513],[32.561245,0.354513],[32.569139,0.339922],[32.569139,0.339922],[32.559186,0.337004],[32.559186,0.337004],[32.548719,0.341638],[32.548891,0.340265]]]}}', '2023-04-21 05:29:30', '2023-04-21 05:29:30'),
(27, '7', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[32.61395,0.383283],[32.61395,0.383283],[32.632825,0.386201],[32.632825,0.386201],[32.638488,0.367318],[32.638488,0.367318],[32.617382,0.363027],[32.617382,0.363027],[32.613778,0.383969],[32.61395,0.383283]]]}}', '2023-04-26 13:22:35', '2023-04-26 13:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_id` int(50) DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `device_id`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '0.34773', '32.562190', 0, '2023-03-21 15:37:29', '2023-03-21 15:37:29'),
(2, 5, '0.34973', '32.562190', 0, '2023-03-21 15:39:19', '2023-03-21 15:39:19'),
(3, 2, '0.3402', '32.66571', 0, '2023-03-24 09:11:55', '2023-03-24 09:11:55'),
(4, 6, '0.3802', '32.5571', 0, '2023-03-28 13:21:07', '2023-03-28 13:21:07'),
(5, 7, '0.37734', '32.6258', 0, '2023-04-20 15:38:14', '2023-04-20 15:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_02_14_085054_create_sessions_table', 1),
(8, '2023_02_16_200154_create_visitors_table', 2),
(9, '2023_03_09_143124_create_orders_table', 3),
(10, '2023_03_16_150130_create_devices_table', 4),
(11, '2023_03_21_094613_create_locations_table', 5),
(12, '2023_03_24_165408_create_geo_fences_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devices` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` smallint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `devices`, `message`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Ogwal Dan', 'ogwal@gmail.com', '0776263482', '2', 'To track kid', '2023-03-09 12:09:30', '2023-03-09 12:09:30', 0),
(3, 'Opio Bosco', 'opio@gmail.com', '0754428612', '5', 'Tracking Cars', '2023-03-09 13:34:25', '2023-03-09 13:34:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ogirekenneth@gmail.com', '$2y$10$UMI2a4R/ljym/i.qF92Wy.nsn.ux6fvTfO0fzBQyE7EYo0RRQdidu', '2023-02-17 06:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UvcArez32Y2p29bIlFiWpmGEmWmMxzlOkJ8zcYVo', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/112.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT0txSWxxN05ISlRYNEV5MTVJZkhtQnFsRk5keDA5QVZaZ1BPR3VFZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmlwL2hpc3RvcnkvNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkOHk5ZmJ3d0ZPSlFJSFAvSWFvNU41LmE2YzJKTHlGQURWdS9IWmk5T2dDR3AvdVQwRFBLNHEiO30=', 1682530102);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) DEFAULT 0,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `status` smallint(1) DEFAULT 0,
  `location` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `contact`, `status`, `location`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Samuel Kiira', 2, 'samuelkiiraeluk@gmail.com', 256754428612, 1, 'Obuto-welo', NULL, '$2y$10$8y9fbwwFOJQIHP/Iao5N5.a6c2JLyFADVu/HZi9OgCGp/uT0DPK4q', NULL, NULL, NULL, 'suJ4gSuTg1vgCFcECi6kuv1p2lBm7kz9Kh097jurwxdT5HEQkcbODeh00SOK', NULL, '1678367240.jpg', '2023-02-14 06:12:29', '2023-03-15 05:49:35'),
(2, 'kenneth Ogire', 2, 'ogirekenneth@gmail.com', 256709279744, 1, 'Nansana', NULL, '$2y$10$E0nJ/4LmK5bqnduyH5RPVu8M2/wBXbTc7kigpep7dKQ8ZSIRZkMFK', NULL, NULL, NULL, NULL, NULL, '1678368921.jpg', '2023-02-16 08:13:54', '2023-03-30 10:32:47'),
(3, 'Okello Martin', 1, 'cypherlinkservices@gmail.com', 256772653056, 1, 'Nakawa', NULL, '$2y$10$4gXTeM20rRCCsatcOJK9COTcy/HalES4mbQ/QdsiCdvSGaidpjmxW', NULL, NULL, NULL, NULL, NULL, '1678177912.jpg', '2023-02-16 08:43:57', '2023-03-30 10:33:30'),
(10, 'Elizabeth Nanyonga', 2, 'nanyongaelizabeth71@gmail.com', 256755367936, 1, 'Entebbe', NULL, '$2y$10$IlB5s0ngP0CE7pdVlqVze.9BJZR.lmgx.3GJyelOjm.ivzVshdWPy', NULL, NULL, NULL, NULL, NULL, '1678367352.jpg', '2023-03-09 06:34:47', '2023-03-30 10:34:03'),
(11, 'Timothy C. Waniaye', 2, 'tcwaniaye@gmail.com', 256778321920, 1, 'Soroti Town', NULL, '$2y$10$DEVcnz5JQ6jk4/05.G1LU.K1KP8PfBL96CZLSbZ58RL/5540VbZ3K', NULL, NULL, NULL, NULL, NULL, '1678369068.jpg', '2023-03-09 06:37:49', '2023-03-30 10:34:50'),
(12, 'Fred SSeginda', 1, 'fredsseginda70@gmail.com', 256709083136, 1, 'Nakawa', NULL, '$2y$10$GKZrOOTIF6p0MJZ.QrHooeJzleCZoRoatrALtZy0snqU0ovWqjf2e', NULL, NULL, NULL, NULL, NULL, '1679334191.jpg', '2023-03-15 08:49:23', '2023-03-30 10:35:15'),
(13, 'The Sealed', 1, 'the5107sealed@yahoo.com', 256754428612, 0, 'Gulu', NULL, '$2y$10$KtxPHBMfJ30f1r2V1lRzOO/FgIj/M/uanxwlvhm6iIoul3bHGko6y', NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-20 12:27:48', '2023-04-20 12:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visited_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visited_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visits` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip`, `visited_date`, `visited_time`, `visits`, `created_at`, `updated_at`) VALUES
(2, '127.0.0.1', '2023-04-26', '16:23:38', '254', '2023-04-26 13:23:38', '2023-04-26 13:23:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `geo_fences`
--
ALTER TABLE `geo_fences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
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
  ADD UNIQUE KEY `orders_email_unique` (`email`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geo_fences`
--
ALTER TABLE `geo_fences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

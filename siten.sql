-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2016 at 10:10 PM
-- Server version: 5.6.28-1ubuntu3
-- PHP Version: 5.6.17-3ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siten`
--

-- --------------------------------------------------------

--
-- Table structure for table `commons`
--

CREATE TABLE `commons` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `commons`
--

INSERT INTO `commons` (`id`, `name`, `value`, `created_at`) VALUES
(1, 'offices', '[{"code":"VT","name":"Viettel"},{"code":"VP","name":"Vinaphone"},{"code":"MF","name":"Mobifone"}]', '2016-04-01 13:36:04'),
(2, 'roles', '[{"code":"ADMIN","name":"Admin"},{"code":"USER","name":"Chung"}]', '2016-04-01 13:36:04'),
(3, 'types', '[{"code":"USE","name":"C\\u00f3 th\\u1ec3 s\\u1eed d\\u1ee5ng"},{"code":"NOT_USE","name":"Kh\\u00f4ng th\\u1ec3 s\\u1eed d\\u1ee5ng"}]', '2016-04-01 13:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_common_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `office` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `office`, `email`, `created_by`, `type`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0001', 'VT', 'god@admin.com', '0001', 'USE', 'ADMIN', '$2y$10$CNb8zaP68RRK.B.hC/0JbOrDjmEqkicssGGIORAyyWfaa7STSb.Yi', 'Yt26RcVw67ibS7mP9c95X0spj91RcEfyeW9wa1DqTjGG39wjRUpUEx1GfyTF', '2016-03-31 17:00:00', '2016-04-01 07:46:05'),
(2, '0002', 'VP', 'god2@admin.com', '0001', 'USE', 'USER', '$2y$10$4ETX667xfpSz8LUpJuTPbOYiSLYP6Eav1qVX4ZlRROQOLD3vwy6Iu', '0ci609JyudIz3UAo2H8dcpJLgCKPW0Unqz6tC6k5qjXXz9elQvlzDfMUyjXX', '2016-04-01 06:36:36', '2016-04-01 07:48:13'),
(3, '0003', 'VT', 'god3@admin.com', '0001', 'USE', 'USER', '$2y$10$thgM7x.GeXnloef6pZi1Qubci5pVFyihrqy4.YfTgYy4/Y7d2WDHq', NULL, '2016-04-01 06:37:58', '2016-04-01 07:46:07'),
(4, '0004', 'VP', 'god4@admin.com', '0001', 'NOT_USE', 'USER', '$2y$10$RvxGv3i2woYtrH.0tF3lxujAsg4JyOEVdf2AHhdPAtiL4swov9kQu', NULL, '2016-04-01 07:37:44', '2016-04-01 07:46:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commons`
--
ALTER TABLE `commons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commons_name_index` (`name`),
  ADD KEY `commons_value_index` (`value`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commons`
--
ALTER TABLE `commons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

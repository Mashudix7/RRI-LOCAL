-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2026 at 01:47 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csirt_rri`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_page_locks`
--

CREATE TABLE `admin_page_locks` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `page` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `recovery_code_hash` varchar(255) NOT NULL,
  `failed_attempts` int DEFAULT '0',
  `locked_until` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(64) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `key`, `client_name`, `is_active`, `created_at`) VALUES
(1, 'CSIRT-LIVE-KEY-12345', 'Default SIEM Connector', 1, '2026-01-22 05:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'Informasi',
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `views` int DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `category`, `slug`, `content`, `excerpt`, `thumbnail`, `author_id`, `status`, `views`, `published_at`, `created_at`, `updated_at`) VALUES
(13, 'dwawwwwwwww', 'Panduan', 'dwawwwwwwww', 'wadddddddddddd', 'waddddddddddd', 'assets/uploads/radio-republik-indonesia-logo-png_seeklogo-4996542.png', NULL, 'published', 0, '2026-01-28 13:43:47', '2026-01-28 06:42:22', '2026-01-28 06:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `request_method` varchar(10) DEFAULT NULL,
  `request_uri` varchar(255) DEFAULT NULL,
  `module` varchar(50) NOT NULL,
  `details` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `response_code` int DEFAULT NULL,
  `execution_time` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `request_method`, `request_uri`, `module`, `details`, `ip_address`, `user_agent`, `response_code`, `execution_time`, `created_at`) VALUES
(1, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 02:29:13'),
(2, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Bahlul', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 02:30:26'),
(3, 4, 'create_article', NULL, NULL, 'article', 'Created article: Pak Pulici', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 02:33:20'),
(4, 4, 'update_article', NULL, NULL, 'audit', 'Updated article ID: 5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:04:53'),
(5, 4, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:07:17'),
(6, 4, 'update_network', NULL, NULL, 'network', 'Updated network ID: 1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:23:19'),
(7, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:44:34'),
(8, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:44:54'),
(9, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:45:09'),
(10, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:45:17'),
(11, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:45:28'),
(12, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:45:40'),
(13, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:45:52'),
(14, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 03:46:05'),
(15, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 04:19:27'),
(16, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 04:43:52'),
(18, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 06:15:18'),
(19, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 06:16:29'),
(20, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 06:44:55'),
(21, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 12:45:24'),
(22, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 13:03:11'),
(23, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 13:41:53'),
(24, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 13:42:57'),
(25, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 15:25:32'),
(26, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:23:35'),
(27, 4, 'update_ip', NULL, NULL, 'ip', 'Updated IP: 218.33.123.128 (active)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:26:47'),
(28, 4, 'update_ip', NULL, NULL, 'ip', 'Updated IP: 218.33.123.128 (inactive)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:27:00'),
(29, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:33:37'),
(30, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:56:30'),
(31, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:56:56'),
(32, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:57:49'),
(33, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:57:53'),
(34, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:57:57'),
(35, 4, 'create_article', NULL, NULL, 'article', 'Created article: Pak pulici maem', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:59:01'),
(36, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 17:59:42'),
(37, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:01:29'),
(38, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:01:45'),
(39, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:09'),
(40, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:16'),
(41, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:21'),
(42, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:32'),
(43, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Pak pulici', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:35'),
(44, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Pak Pulicii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:03:38'),
(45, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:04:44'),
(46, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:04:48'),
(47, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:04:54'),
(48, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:19:04'),
(49, 4, 'create_article', NULL, NULL, 'article', 'Created article: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:19:40'),
(50, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:22:23'),
(51, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Test Laporan Article 1769192776', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:40:35'),
(52, 4, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:46:54'),
(53, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:48:02'),
(54, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:53:55'),
(55, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:54:01'),
(56, 4, 'create_article', NULL, NULL, 'article', 'Created article: Test', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:54:34'),
(57, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:54:40'),
(58, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:55:10'),
(59, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:55:33'),
(60, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 18:56:43'),
(61, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:08:38'),
(62, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:08:44'),
(63, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Tes', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:08:48'),
(64, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:08:55'),
(65, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:09:00'),
(66, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:11:55'),
(67, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:12:36'),
(68, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:13:03'),
(69, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Cekcscs', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:13:06'),
(70, 4, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:13:12'),
(71, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-23 19:14:04'),
(73, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 02:58:50'),
(74, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:11:58'),
(75, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:13:41'),
(76, 4, 'create_article', NULL, NULL, 'article', 'Created article: qqqqqqqqqqqqqqqq', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:13:55'),
(77, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:19:32'),
(78, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:19:47'),
(79, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:24:42'),
(80, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:24:45'),
(81, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:24:47'),
(82, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:24:53'),
(83, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:29:26'),
(84, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:34:38'),
(85, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:34:46'),
(86, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:34:51'),
(87, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:35:04'),
(88, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:39:42'),
(89, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:40:01'),
(90, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:40:06'),
(91, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:40:27'),
(92, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:41:27'),
(93, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:41:35'),
(94, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:42:35'),
(95, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:42:42'),
(96, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:42:42'),
(97, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:46:47'),
(98, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:46:51'),
(99, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:48:55'),
(100, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:49:00'),
(101, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:54:03'),
(102, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 03:54:12'),
(103, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:02:32'),
(104, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:02:38'),
(105, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:05:40'),
(106, 5, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:05:52'),
(107, 5, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:06:35'),
(109, 5, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:06:50'),
(110, 5, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:08:12'),
(111, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:08:23'),
(112, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:17:26'),
(113, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:17:32'),
(114, 4, 'update_network', NULL, NULL, 'network', 'Updated network ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:26:14'),
(115, 4, 'update_network', NULL, NULL, 'network', 'Updated network ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:26:29'),
(116, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:31:17'),
(117, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-24 04:31:25'),
(118, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:00:47'),
(119, 4, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:02:27'),
(121, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:21:29'),
(122, 4, 'create_article', NULL, NULL, 'article', 'Created article: Test Mobile', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:22:39'),
(123, 4, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:22:47'),
(125, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-25 15:40:44'),
(126, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-25 16:09:08'),
(127, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-25 17:05:31'),
(128, 4, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-25 17:15:07'),
(129, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-25 17:15:14'),
(130, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 01:47:36'),
(131, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 01:47:48'),
(132, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 01:48:01'),
(133, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 02:29:40'),
(134, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 02:43:41'),
(135, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 04:27:42'),
(136, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 04:29:12'),
(137, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 04:32:24'),
(138, 4, 'delete_article', NULL, NULL, 'article', 'Deleted article: Test ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 04:32:29'),
(139, 4, 'update_ip', NULL, NULL, 'ip', 'Updated IP: 218.33.123.2 (inactive)', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-26 04:33:05'),
(140, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:26:46'),
(141, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:44:00'),
(142, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:44:27'),
(143, 4, 'delete_team', NULL, NULL, 'team', 'Deleted team member: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:44:30'),
(144, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Yatno', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:44:48'),
(145, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Achmad S.D.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:45:28'),
(146, 4, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:45:38'),
(147, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Randy A.P.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:45:59'),
(148, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Ade Solihin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:46:06'),
(149, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Michael S', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:46:17'),
(150, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Sarah Putri T', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:46:30'),
(151, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Farras F', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:46:41'),
(152, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Mugiamano', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:47:12'),
(153, 4, 'create_team', NULL, NULL, 'team', 'Added team member: M Subur', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:47:39'),
(154, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Yudha Panca', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:47:50'),
(155, 4, 'create_team', NULL, NULL, 'team', 'Added team member: M. Faizal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:48:02'),
(156, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Dema Arief', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:48:15'),
(157, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Andrea S.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:48:29'),
(158, 4, 'create_team', NULL, NULL, 'team', 'Added team member: M. Rizki Azizi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:48:44'),
(159, 4, 'create_team', NULL, NULL, 'team', 'Added team member: M. Dhiya', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:48:58'),
(160, 4, 'create_team', NULL, NULL, 'team', 'Added team member: Ali Syauqi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 02:49:09'),
(161, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.173', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-27 03:21:42'),
(162, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 05:43:41'),
(163, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 05:43:47'),
(164, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:10:11'),
(165, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:22:41'),
(166, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:22:50'),
(167, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:22:59'),
(168, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:24:27'),
(169, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:28:57'),
(170, 4, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 07:29:54'),
(171, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 11:08:59'),
(172, 4, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 11:09:34'),
(173, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:35:05'),
(174, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:37:41'),
(175, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:37:46'),
(176, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:37:55'),
(177, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:38:03'),
(178, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:41:58'),
(179, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:42:19'),
(180, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:45:33'),
(181, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:45:39'),
(182, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:50:35'),
(183, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-27 13:51:32'),
(184, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', NULL, NULL, '2026-01-27 13:52:11'),
(185, 4, 'update_user', NULL, NULL, 'user', 'Updated user ID: 3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:53:34'),
(186, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:53:41'),
(187, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:53:48'),
(188, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:59:01'),
(189, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 13:59:11'),
(190, 4, 'create_user', NULL, NULL, 'user', 'Created user: Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:02:31'),
(191, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:02:41'),
(192, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:05:39'),
(193, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:11:35'),
(194, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:15:52'),
(195, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:18:01'),
(196, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:19:47'),
(197, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:23:57'),
(198, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:26:00'),
(199, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:26:15'),
(200, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:26:36'),
(201, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-27 14:28:29'),
(202, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:22:42'),
(203, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:23:39'),
(204, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:23:44'),
(205, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:24:01'),
(206, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:24:09'),
(207, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:27:55'),
(209, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:31:02'),
(213, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:47:54'),
(214, 4, 'create_user', NULL, NULL, 'user', 'Created user: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:51:49'),
(215, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:51:56'),
(216, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 01:52:06'),
(217, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 02:09:41'),
(218, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 03:23:33'),
(219, NULL, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 03:27:30'),
(220, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 03:27:33'),
(221, 4, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 03:32:26'),
(222, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-28 03:32:29'),
(223, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 04:18:48'),
(224, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:17:42'),
(225, NULL, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:37:29'),
(226, NULL, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:37:43'),
(227, NULL, 'update_team', NULL, NULL, 'team', 'Updated team member ID: 37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:37:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `request_method`, `request_uri`, `module`, `details`, `ip_address`, `user_agent`, `response_code`, `execution_time`, `created_at`) VALUES
(228, NULL, 'update_user', NULL, NULL, 'user', 'Updated user ID: 7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:38:34'),
(229, NULL, 'update_article', NULL, NULL, 'article', 'Updated article ID: 10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:39:04'),
(230, NULL, 'delete_article', NULL, NULL, 'article', 'Deleted article: Test', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:39:13'),
(231, NULL, 'create_article', NULL, NULL, 'article', 'Created article: dwwwwwwwwwwwwwwww', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:39:32'),
(232, NULL, 'delete_article', NULL, NULL, 'article', 'Deleted article: dwwwwwwwwwwwwwwww', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:39:36'),
(233, NULL, 'create_article', NULL, NULL, 'article', 'Created article: dwawwwwwwww', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:42:22'),
(234, NULL, 'update_article', NULL, NULL, 'article', 'Updated article ID: 13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:43:47'),
(235, NULL, 'update_user', NULL, NULL, 'user', 'Updated user ID: 7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:48:35'),
(236, NULL, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:48:51'),
(237, 4, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:48:59'),
(238, 4, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:49:03'),
(239, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 06:49:19'),
(241, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 11:59:11'),
(242, NULL, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 13:01:26'),
(243, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 13:01:54'),
(244, NULL, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 13:14:24'),
(245, NULL, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 13:14:26'),
(246, NULL, 'create_user', NULL, NULL, 'user', 'Created user: cek', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 13:55:28'),
(255, 10, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:31:28'),
(256, 10, 'delete_user', NULL, NULL, 'user', 'Deleted user: Nur', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:31:37'),
(257, 10, 'delete_user', NULL, NULL, 'user', 'Deleted user: cek', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:31:41'),
(258, 10, 'create_user', NULL, NULL, 'user', 'Created user: Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:32:17'),
(259, 10, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:32:22'),
(260, 11, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 14:32:30'),
(261, 11, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 15:23:32'),
(262, 11, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 15:23:38'),
(263, 11, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-28 16:16:20'),
(264, 11, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:36:13'),
(265, 11, 'delete_user', NULL, NULL, 'user', 'Deleted user: admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:36:31'),
(266, 11, 'create_user', NULL, NULL, 'user', 'Created user: Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:36:50'),
(267, 11, 'update_user', NULL, NULL, 'user', 'Updated user ID: 12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:36:56'),
(268, 11, 'logout', NULL, NULL, 'system', 'User logged out', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:36:59'),
(269, 12, 'login', NULL, NULL, 'system', 'User logged in successfully', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', NULL, NULL, '2026-01-29 01:37:11'),
(271, 11, 'login', NULL, NULL, 'system', 'User logged in successfully', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-29 01:40:44'),
(272, 11, 'logout', NULL, NULL, 'system', 'User logged out', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, NULL, '2026-01-29 01:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` mediumblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('006hldj7obbjduleiqchh54lnja6i9tj', '::1', 1769494611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439343631313b),
('0vh1dcb9hqb8mmsainn19q508epfsgfk', '::1', 1769523088, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333038383b),
('10jbg2ppg0kop8sioq5kb7dhkp9s4lk6', '::1', 1769609541, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630393533303b6572726f727c733a32393a22557365726e616d6520617461752070617373776f72642073616c61682e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('20rblufh7lofv3kb51s1cgv4ocu7v0os', '::1', 1769523837, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333833373b746573745f7661727c733a31393a2248656c6c6f2066726f6d2031353a32333a3436223b),
('33v8s4rfgq6vupjetvc745a48ak6gste', '::1', 1769651153, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393635303933333b757365725f69647c733a323a223132223b757365726e616d657c733a353a224661687269223b726f6c657c733a373a2261756469746f72223b726f6c655f6e616d657c733a373a2241756469746f72223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393635303633313b6c6173745f61637469766974797c693a313736393635313135323b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a31383a2264656661756c745f6176617461722e706e67223b),
('3lmaruu8gh88b5coqonus03m10g7pv86', '::1', 1769571331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393537313135323b757365725f69647c733a313a2237223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393536363138313b6c6173745f61637469766974797c693a313736393537303530333b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393536353130392e6a7067223b),
('3u8tpfhmcibf0o467hntsrpjasuh4d0q', '::1', 1769523587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333538373b),
('4f88s6a0v77kd34378ir7tq29n1jenbb', '::1', 1769606006, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363030363b),
('57i33u0m111ule8k1auo6loh7csfujjm', '::1', 1769606045, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363034353b),
('667fdbshvmelb0prtpvtugf8ciag0kfa', '::1', 1769606146, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363134363b),
('705d7rro495gs22iq20pd224854h4jgu', '::1', 1769607225, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630373232353b),
('7molg3s31dtd3cgogk25sihasss6gmpc', '::1', 1769522331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532323333313b757365725f69647c733a313a2233223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393532323032383b6c6173745f61637469766974797c693a313736393532323032383b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393131303038312e6a7067223b6572726f727c733a34393a22416e646120746964616b206461706174206d656e677562616820726f6c6520616b756e20416e64612073656e6469726921223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('7pjukj706t3p1ecsrfs17b6gisllj5el', '192.168.233.115', 1769491924, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439313930323b),
('85j8sahgsdoueid8ono2sti9urkdj60q', '::1', 1769606095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363039353b),
('90ok60oi4g5o43m13ug6ogucl3ue95mi', '::1', 1769523996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333939363b),
('945i30pb17qvgmtb4kfg2ouk7c46a318', '::1', 1769500828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393530303634333b757365725f69647c733a313a2233223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393439383536313b6c6173745f61637469766974797c693a313736393439383536313b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393131303038312e6a7067223b),
('9g2g65cqmulhdrvpffm9uejm43rc7r42', '::1', 1769606043, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363034333b),
('9t9o036qo7sfq59g69jcq96fqc0vh01n', '::1', 1769606087, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363038373b),
('a3637vagr64tlgilfs2t4oslst2a6e4b', '::1', 1769587896, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393538373632393b757365725f69647c733a313a2237223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393538323935393b6c6173745f61637469766974797c693a313736393538373438363b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393536353130392e6a7067223b),
('a4q1u008j50p79qsotlvpf474kh74snm', '::1', 1769606071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363037313b),
('b9ch79llm1pnhainjqtvmqsa94ck11lg', '192.168.233.179', 1769571190, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393537313134393b757365725f69647c733a313a2234223b757365726e616d657c733a353a224661687269223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393537313134393b6c6173745f61637469766974797c693a313736393537313134393b6c6f67696e5f69707c733a31353a223139322e3136382e3233332e313739223b6176617461727c733a32313a226176617461725f313736393131303331312e6a7067223b),
('d8b99pttm32a9jp74oerde227h3ttk6s', '::1', 1769606071, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363037313b),
('euhcc961kq54hqnhobtsfaou7jbh3g4b', '::1', 1769524112, ''),
('f38hjn5afh4rca223oe3ordhe07mh00b', '192.168.233.173', 1769491176, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439313137363b757365725f69647c733a313a2233223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393438343130323b6c6173745f61637469766974797c693a313736393438343130323b6c6f67696e5f69707c733a31353a223139322e3136382e3233332e313733223b6176617461727c733a32313a226176617461725f313736393131303038312e6a7067223b),
('fea6qjqape7samdoakqafdqcgpln9jtv', '192.168.233.185', 1769498472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439383435363b),
('fqdus7oa4s15o6cq46pub5n3dhpka0rh', '::1', 1769524109, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532343130393b),
('g3rh25leqt69anoa8nmqrhn21kispq0j', '::1', 1769575168, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393537343936313b757365725f69647c733a313a2237223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393537333932383b6c6173745f61637469766974797c693a313736393537353135383b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393536353130392e6a7067223b),
('i2dsn0rvhbilje2u10fp5btpt8pb8mg5', '::1', 1769606035, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363033353b),
('ifb571eiuqh4uc9luc26li8an6k29b1n', '192.168.20.33', 1769498994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439383939343b),
('io1qup01eed417bc13rit9hmdullrd2p', '::1', 1769606007, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363030373b),
('ip2e8blckcibflpd7b8degqq8mp5agfj', '::1', 1769523960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333936303b),
('itb8pd5bkj1k95llk8moos6s6ms4c4cf', '::1', 1769524023, ''),
('jcd6v1vvvkflgem28r13594an7h7ov9o', '::1', 1769606210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363231303b),
('jt9889ldgpo7m3e1rr3ss5upahg02vc1', '192.168.0.101', 1769520951, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532303935313b),
('k5n77u7ba7ffqgd9ke2qgl7sasrbe8c5', '127.0.0.1', 1769494095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439343039343b),
('kop2id8d6vnd73vbiq0mcvn6qr94p3ob', '::1', 1769523975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333937353b),
('m07vh9fka3mi9l5eh51gg86curbv91th', '::1', 1769490458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439303435383b),
('m8fo6cvhrjn87d9gi129rib1gv8buqn7', '192.168.20.33', 1769651161, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393635313136313b),
('mi6afjinidkuioio4qtr2m97c8sm1su1', '::1', 1769617447, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393631373238383b757365725f69647c733a323a223131223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393631363938303b6c6173745f61637469766974797c693a313736393631373433363b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393631303733372e706e67223b),
('nkd1frme7rssj8vo09e5lsf3v0mqd7ug', '192.168.233.175', 1769493794, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439333534353b757365725f69647c733a313a2233223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393439323632373b6c6173745f61637469766974797c693a313736393439323632373b6c6f67696e5f69707c733a31353a223139322e3136382e3233332e313735223b6176617461727c733a32313a226176617461725f313736393131303038312e6a7067223b),
('nlp2u70m7v4oriqb9h2b0kl1deg7qjav', '192.168.0.102', 1769521126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532303939393b),
('nuv3bpeogpdachut19gtg4c72k2lj8k5', '::1', 1769606074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363037343b),
('o9la82tnsas0stl1aa05b04l9kdcgl2r', '::1', 1769606097, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630363039373b),
('orioarqpk5v3pn2qi8g5bh65p325hobr', '::1', 1769611042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393631303735303b757365725f69647c733a323a223131223b757365726e616d657c733a373a224d617368756469223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393631303735303b6c6173745f61637469766974797c693a313736393631303735303b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a32313a226176617461725f313736393631303733372e706e67223b),
('p550l08grmaohgde42vvp54fcrsc3c71', '::1', 1769523960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333936303b757365725f69647c733a313a2236223b757365726e616d657c733a383a224d61736875646969223b726f6c657c733a31303a22737570657261646d696e223b726f6c655f6e616d657c733a31303a22537570657261646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393532333936303b6c6173745f61637469766974797c693a313736393532333936303b6c6f67696e5f69707c733a333a223a3a31223b6176617461727c733a31383a2264656661756c745f6176617461722e706e67223b746f6173745f737563636573737c733a34303a224c6f67696e20626572686173696c212053656c616d617420646174616e672c204d61736875646969223b5f5f63695f766172737c613a313a7b733a31333a22746f6173745f73756363657373223b733a333a226f6c64223b7d),
('pp2rbi6h1gksobvbll4er774t28ei1gc', '::1', 1769601541, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393630313534313b),
('qkdofve1315tompvnq881efacefqc86c', '::1', 1769495354, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439353335343b),
('rced01pp7754tfi06rsh5hmrjk4temva', '::1', 1769490120, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439303132303b),
('rgkhuasmojj3o6t1mqstrie2h7i9badq', '::1', 1769523481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393532333438313b),
('sc1qul9e1o5uq3h2ij2o1eapkcjmal3q', '::1', 1769581055, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393538313035353b),
('sfg5e13fpnqjkm6n1nd94dfmvl6nimqf', '192.168.233.179', 1769496220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393439353938303b757365725f69647c733a313a2234223b757365726e616d657c733a353a224661687269223b726f6c657c733a353a2261646d696e223b726f6c655f6e616d657c733a353a2241646d696e223b6c6f676765645f696e7c623a313b6c6f67696e5f74696d657c693a313736393439323632313b6c6173745f61637469766974797c693a313736393439323632313b6c6f67696e5f69707c733a31353a223139322e3136382e3233332e313739223b6176617461727c733a32313a226176617461725f313736393131303331312e6a7067223b),
('sr2q0dmbde83een3s71d9a23633egf71', '::1', 1769613148, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393631333134383b);

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `case_ref_no` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` int UNSIGNED NOT NULL,
  `file_hash` varchar(64) NOT NULL,
  `uploaded_by` int NOT NULL,
  `notes` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `severity` enum('critical','high','medium','low') NOT NULL,
  `status` enum('reported','validated','in_progress','mitigated','recovered','closed') DEFAULT 'reported',
  `affected_systems` text,
  `initial_assessment` text,
  `reporter_id` int DEFAULT NULL,
  `assignee_id` int DEFAULT NULL,
  `detection_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_attachments`
--

CREATE TABLE `incident_attachments` (
  `id` int NOT NULL,
  `incident_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_notes`
--

CREATE TABLE `incident_notes` (
  `id` int NOT NULL,
  `incident_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` text NOT NULL,
  `type` enum('comment','activity','system') DEFAULT 'comment',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `type` enum('public','private','local','vpn','gateway') NOT NULL DEFAULT 'public',
  `region` varchar(100) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `usage_status` enum('in_use','available') DEFAULT 'available',
  `app_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `network_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ip_addresses`
--

INSERT INTO `ip_addresses` (`id`, `name`, `ip_address`, `type`, `region`, `description`, `status`, `usage_status`, `app_name`, `created_at`, `updated_at`, `network_id`) VALUES
(1, '', '218.33.123.1', 'gateway', NULL, 'Gateway1', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 12:17:11', 1),
(2, '', '218.33.123.2', 'public', NULL, 'Internet DNS Server Lokal', 'inactive', 'available', NULL, '2026-01-22 16:00:06', '2026-01-26 04:33:05', 1),
(3, '', '218.33.123.3', 'public', NULL, 'Internet Aplikasi NextCloud', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(4, '', '218.33.123.4', 'public', NULL, 'Aplikasi AudioLibrary', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(5, '', '218.33.123.5', 'public', NULL, 'Internet PPID RRI', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(6, '', '218.33.123.6', 'public', NULL, 'Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(7, '', '218.33.123.7', 'public', NULL, 'Aplikasi Drive Cloud', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(8, '', '218.33.123.8', 'public', NULL, 'WAF-Jakarta', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(9, '', '218.33.123.9', 'public', NULL, 'Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(10, '', '218.33.123.10', 'public', NULL, 'Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(11, '', '218.33.123.11', 'public', NULL, 'Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(12, '', '218.33.123.12', 'public', NULL, 'Streaming Sentral', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(13, '', '218.33.123.13', 'public', NULL, 'Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(14, '', '218.33.123.14', 'public', NULL, 'GL Audio Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(15, '', '218.33.123.15', 'public', NULL, 'SIP Server Lama', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(16, '', '218.33.123.16', 'public', NULL, 'Zabbix All NMS', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(17, '', '218.33.123.17', 'public', NULL, 'Aplikasi Meeting TMB', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(18, '', '218.33.123.18', 'public', NULL, 'Aplikasi Video GL', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(19, '', '218.33.123.19', 'public', NULL, 'Omada Controller', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(20, '', '218.33.123.20', 'public', NULL, 'Aplikasi Sisporja NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(21, '', '218.33.123.21', 'public', NULL, 'Unify Controller Pusat', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(22, '', '218.33.123.22', 'public', NULL, 'DC JKT Cloud Proxmox VE', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(23, '', '218.33.123.23', 'public', NULL, 'Aplikasi DAP & MEDIA', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(24, '', '218.33.123.24', 'public', NULL, 'Intranet JKT', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(25, '', '218.33.123.25', 'public', NULL, 'Aplikasi Supporting Server', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(26, '', '218.33.123.26', 'public', NULL, 'IP PUBLIK NEW PRO 1', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(27, '', '218.33.123.27', 'public', NULL, 'IP PUBLIK NEW PRO 2', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(28, '', '218.33.123.28', 'public', NULL, 'IP PUBLIK NEW PRO 4', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(29, '', '218.33.123.29', 'public', NULL, 'Global Media Academy', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(30, '', '218.33.123.30', 'public', NULL, 'Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(31, '', '218.33.123.31', 'public', NULL, 'Aplikasi PNBP NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(32, '', '218.33.123.32', 'public', NULL, 'Aplikasi PNet Lab', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(33, '', '218.33.123.33', 'public', NULL, 'IoT Siaga', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(34, '', '218.33.123.34', 'public', NULL, 'IP Extend Portal Berita RRI', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(35, '', '218.33.123.35', 'public', NULL, 'IP Private-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(36, '', '218.33.123.36', 'public', NULL, 'Aplikasi Mail Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(37, '', '218.33.123.37', 'public', NULL, 'Aplikasi Mail Gateway Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(38, '', '218.33.123.38', 'public', NULL, 'Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(39, '', '218.33.123.39', 'public', NULL, 'Aplikasi WAZUH SOC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(40, '', '218.33.123.40', 'public', NULL, 'DevOps', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(41, '', '218.33.123.41', 'public', NULL, 'RRI Digital 1', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(42, '', '218.33.123.42', 'public', NULL, 'RRI Digital 2', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(43, '', '218.33.123.43', 'public', NULL, 'RRI Digital 3', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(44, '', '218.33.123.44', 'public', NULL, 'S3 RRI Digital', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(45, '', '218.33.123.45', 'public', NULL, 'NextCloud Collabora', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(46, '', '218.33.123.46', 'public', NULL, 'Docker Swarm', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(47, '', '218.33.123.47', 'public', NULL, 'My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(48, '', '218.33.123.48', 'public', NULL, 'LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(49, '', '218.33.123.49', 'public', NULL, 'MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(50, '', '218.33.123.50', 'public', NULL, 'JDIH Nginx', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(51, '', '218.33.123.51', 'public', NULL, 'Codec Backup', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(52, '', '218.33.123.52', 'public', NULL, 'H3C', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(53, '', '218.33.123.53', 'public', NULL, 'Aplikasi DIAS', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(54, '', '218.33.123.54', 'public', NULL, 'IP Router Firewall DC Jakarta', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(55, '', '218.33.123.56', 'public', NULL, 'TrueNas', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(56, '', '218.33.123.57', 'public', NULL, 'internet Gedung Sebelah (sebelumnya digunakan LPU)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(57, '', '218.33.123.58', 'public', NULL, 'CMS Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(58, '', '218.33.123.59', 'public', NULL, 'Front Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(59, '', '218.33.123.60', 'public', NULL, 'Server API Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 1),
(60, '', '218.33.123.65', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(61, '', '218.33.123.66', 'public', NULL, 'IP Router 1', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(62, '', '218.33.123.67', 'public', NULL, 'IP Router 2', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(63, '', '218.33.123.68', 'public', NULL, 'IP Server', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(64, '', '218.33.123.69', 'public', NULL, 'IP API Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(65, '', '218.33.123.70', 'public', NULL, 'IP CMS Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(66, '', '218.33.123.71', 'public', NULL, 'IP Frontend Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(67, '', '218.33.123.72', 'public', NULL, 'IP Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(68, '', '218.33.123.73', 'public', NULL, 'IP Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(69, '', '218.33.123.74', 'public', NULL, 'IP Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(70, '', '218.33.123.75', 'public', NULL, 'IP WAF DC PDN Serpong', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(71, '', '218.33.123.76', 'public', NULL, 'IP S3 Portal', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 2),
(72, '', '218.33.123.129', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 3),
(73, '', '218.33.123.130', 'public', NULL, 'IP Firewall Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 3),
(74, '', '218.33.123.131', 'public', NULL, 'IP Router Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 3),
(75, '', '218.33.123.193', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(76, '', '218.33.123.194', 'public', NULL, 'Internet Semua Perangkat DC MBC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(77, '', '218.33.123.195', 'public', NULL, 'Aplikasi Manajemen IP', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(78, '', '218.33.123.196', 'public', NULL, 'Aplikasi Pusdatin NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(79, '', '218.33.123.197', 'public', NULL, 'Aplikasi JDIH NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(80, '', '218.33.123.198', 'public', NULL, 'IP Internet Server Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(81, '', '218.33.123.199', 'public', NULL, 'IP Internet Server Docker MBC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(82, '', '218.33.123.200', 'public', NULL, 'T-Track Pemancar', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(83, '', '218.33.123.201', 'public', NULL, 'IP Publik Email Corporate RRI (rri.go.id)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(84, '', '218.33.123.202', 'public', NULL, 'Aplikasi DRM Proxy', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(85, '', '218.33.123.203', 'public', NULL, 'Aplikasi WAF MBC', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(86, '', '218.33.123.204', 'public', NULL, 'Aplikasi Jenkins Git Docker', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(87, '', '218.33.123.205', 'public', NULL, 'IP Router Core Operasional', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(88, '', '218.33.123.206', 'public', NULL, 'IP Publik-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(89, '', '218.33.123.207', 'public', NULL, 'IP Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(90, '', '218.33.123.208', 'public', NULL, 'IP Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(91, '', '218.33.123.209', 'public', NULL, 'IP My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(92, '', '218.33.123.210', 'public', NULL, 'IP LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(93, '', '218.33.123.211', 'public', NULL, 'IP MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(94, '', '218.33.123.212', 'public', NULL, 'IP Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:00:06', '2026-01-22 16:00:06', 6),
(95, '', '218.33.123.1', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(96, '', '218.33.123.2', 'public', NULL, 'Internet DNS Server Lokal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(97, '', '218.33.123.3', 'public', NULL, 'Internet Aplikasi NextCloud', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(98, '', '218.33.123.4', 'public', NULL, 'Aplikasi AudioLibrary', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(99, '', '218.33.123.5', 'public', NULL, 'Internet PPID RRI', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(100, '', '218.33.123.6', 'public', NULL, 'Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(101, '', '218.33.123.7', 'public', NULL, 'Aplikasi Drive Cloud', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(102, '', '218.33.123.8', 'public', NULL, 'WAF-Jakarta', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(103, '', '218.33.123.9', 'public', NULL, 'Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(104, '', '218.33.123.10', 'public', NULL, 'Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(105, '', '218.33.123.11', 'public', NULL, 'Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(106, '', '218.33.123.12', 'public', NULL, 'Streaming Sentral', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(107, '', '218.33.123.13', 'public', NULL, 'Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(108, '', '218.33.123.14', 'public', NULL, 'GL Audio Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(109, '', '218.33.123.15', 'public', NULL, 'SIP Server Lama', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(110, '', '218.33.123.16', 'public', NULL, 'Zabbix All NMS', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(111, '', '218.33.123.17', 'public', NULL, 'Aplikasi Meeting TMB', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(112, '', '218.33.123.18', 'public', NULL, 'Aplikasi Video GL', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(113, '', '218.33.123.19', 'public', NULL, 'Omada Controller', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(114, '', '218.33.123.20', 'public', NULL, 'Aplikasi Sisporja NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(115, '', '218.33.123.21', 'public', NULL, 'Unify Controller Pusat', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(116, '', '218.33.123.22', 'public', NULL, 'DC JKT Cloud Proxmox VE', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(117, '', '218.33.123.23', 'public', NULL, 'Aplikasi DAP & MEDIA', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(118, '', '218.33.123.24', 'public', NULL, 'Intranet JKT', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(119, '', '218.33.123.25', 'public', NULL, 'Aplikasi Supporting Server', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(120, '', '218.33.123.26', 'public', NULL, 'IP PUBLIK NEW PRO 1', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(121, '', '218.33.123.27', 'public', NULL, 'IP PUBLIK NEW PRO 2', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(122, '', '218.33.123.28', 'public', NULL, 'IP PUBLIK NEW PRO 4', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(123, '', '218.33.123.29', 'public', NULL, 'Global Media Academy', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(124, '', '218.33.123.30', 'public', NULL, 'Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(125, '', '218.33.123.31', 'public', NULL, 'Aplikasi PNBP NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(126, '', '218.33.123.32', 'public', NULL, 'Aplikasi PNet Lab', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(127, '', '218.33.123.33', 'public', NULL, 'IoT Siaga', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(128, '', '218.33.123.34', 'public', NULL, 'IP Extend Portal Berita RRI', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(129, '', '218.33.123.35', 'public', NULL, 'IP Private-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(130, '', '218.33.123.36', 'public', NULL, 'Aplikasi Mail Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(131, '', '218.33.123.37', 'public', NULL, 'Aplikasi Mail Gateway Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(132, '', '218.33.123.38', 'public', NULL, 'Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(133, '', '218.33.123.39', 'public', NULL, 'Aplikasi WAZUH SOC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(134, '', '218.33.123.40', 'public', NULL, 'DevOps', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(135, '', '218.33.123.41', 'public', NULL, 'RRI Digital 1', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(136, '', '218.33.123.42', 'public', NULL, 'RRI Digital 2', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(137, '', '218.33.123.43', 'public', NULL, 'RRI Digital 3', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(138, '', '218.33.123.44', 'public', NULL, 'S3 RRI Digital', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(139, '', '218.33.123.45', 'public', NULL, 'NextCloud Collabora', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(140, '', '218.33.123.46', 'public', NULL, 'Docker Swarm', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(141, '', '218.33.123.47', 'public', NULL, 'My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(142, '', '218.33.123.48', 'public', NULL, 'LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(143, '', '218.33.123.49', 'public', NULL, 'MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(144, '', '218.33.123.50', 'public', NULL, 'JDIH Nginx', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(145, '', '218.33.123.51', 'public', NULL, 'Codec Backup', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(146, '', '218.33.123.52', 'public', NULL, 'H3C', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(147, '', '218.33.123.53', 'public', NULL, 'Aplikasi DIAS', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(148, '', '218.33.123.54', 'public', NULL, 'IP Router Firewall DC Jakarta', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(149, '', '218.33.123.56', 'public', NULL, 'TrueNas', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(150, '', '218.33.123.57', 'public', NULL, 'internet Gedung Sebelah (sebelumnya digunakan LPU)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(151, '', '218.33.123.58', 'public', NULL, 'CMS Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(152, '', '218.33.123.59', 'public', NULL, 'Front Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(153, '', '218.33.123.60', 'public', NULL, 'Server API Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 1),
(154, '', '218.33.123.65', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(155, '', '218.33.123.66', 'public', NULL, 'IP Router 1', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(156, '', '218.33.123.67', 'public', NULL, 'IP Router 2', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(157, '', '218.33.123.68', 'public', NULL, 'IP Server', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(158, '', '218.33.123.69', 'public', NULL, 'IP API Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(159, '', '218.33.123.70', 'public', NULL, 'IP CMS Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(160, '', '218.33.123.71', 'public', NULL, 'IP Frontend Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(161, '', '218.33.123.72', 'public', NULL, 'IP Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(162, '', '218.33.123.73', 'public', NULL, 'IP Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(163, '', '218.33.123.74', 'public', NULL, 'IP Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(164, '', '218.33.123.75', 'public', NULL, 'IP WAF DC PDN Serpong', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(165, '', '218.33.123.76', 'public', NULL, 'IP S3 Portal', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 2),
(166, '', '218.33.123.129', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 3),
(167, '', '218.33.123.130', 'public', NULL, 'IP Firewall Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 3),
(168, '', '218.33.123.131', 'public', NULL, 'IP Router Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 3),
(169, '', '218.33.123.193', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(170, '', '218.33.123.194', 'public', NULL, 'Internet Semua Perangkat DC MBC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(171, '', '218.33.123.195', 'public', NULL, 'Aplikasi Manajemen IP', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(172, '', '218.33.123.196', 'public', NULL, 'Aplikasi Pusdatin NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(173, '', '218.33.123.197', 'public', NULL, 'Aplikasi JDIH NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(174, '', '218.33.123.198', 'public', NULL, 'IP Internet Server Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(175, '', '218.33.123.199', 'public', NULL, 'IP Internet Server Docker MBC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(176, '', '218.33.123.200', 'public', NULL, 'T-Track Pemancar', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(177, '', '218.33.123.201', 'public', NULL, 'IP Publik Email Corporate RRI (rri.go.id)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(178, '', '218.33.123.202', 'public', NULL, 'Aplikasi DRM Proxy', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(179, '', '218.33.123.203', 'public', NULL, 'Aplikasi WAF MBC', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(180, '', '218.33.123.204', 'public', NULL, 'Aplikasi Jenkins Git Docker', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(181, '', '218.33.123.205', 'public', NULL, 'IP Router Core Operasional', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(182, '', '218.33.123.206', 'public', NULL, 'IP Publik-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(183, '', '218.33.123.207', 'public', NULL, 'IP Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(184, '', '218.33.123.208', 'public', NULL, 'IP Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(185, '', '218.33.123.209', 'public', NULL, 'IP My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(186, '', '218.33.123.210', 'public', NULL, 'IP LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(187, '', '218.33.123.211', 'public', NULL, 'IP MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(188, '', '218.33.123.212', 'public', NULL, 'IP Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:02:08', '2026-01-22 16:02:08', 6),
(189, '', '218.33.123.1', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(190, '', '218.33.123.2', 'public', NULL, 'Internet DNS Server Lokal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(191, '', '218.33.123.3', 'public', NULL, 'Internet Aplikasi NextCloud', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(192, '', '218.33.123.4', 'public', NULL, 'Aplikasi AudioLibrary', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(193, '', '218.33.123.5', 'public', NULL, 'Internet PPID RRI', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(194, '', '218.33.123.6', 'public', NULL, 'Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(195, '', '218.33.123.7', 'public', NULL, 'Aplikasi Drive Cloud', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(196, '', '218.33.123.8', 'public', NULL, 'WAF-Jakarta', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(197, '', '218.33.123.9', 'public', NULL, 'Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(198, '', '218.33.123.10', 'public', NULL, 'Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(199, '', '218.33.123.11', 'public', NULL, 'Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(200, '', '218.33.123.12', 'public', NULL, 'Streaming Sentral', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(201, '', '218.33.123.13', 'public', NULL, 'Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(202, '', '218.33.123.14', 'public', NULL, 'GL Audio Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(203, '', '218.33.123.15', 'public', NULL, 'SIP Server Lama', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(204, '', '218.33.123.16', 'public', NULL, 'Zabbix All NMS', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(205, '', '218.33.123.17', 'public', NULL, 'Aplikasi Meeting TMB', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(206, '', '218.33.123.18', 'public', NULL, 'Aplikasi Video GL', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(207, '', '218.33.123.19', 'public', NULL, 'Omada Controller', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(208, '', '218.33.123.20', 'public', NULL, 'Aplikasi Sisporja NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(209, '', '218.33.123.21', 'public', NULL, 'Unify Controller Pusat', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(210, '', '218.33.123.22', 'public', NULL, 'DC JKT Cloud Proxmox VE', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(211, '', '218.33.123.23', 'public', NULL, 'Aplikasi DAP & MEDIA', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(212, '', '218.33.123.24', 'public', NULL, 'Intranet JKT', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(213, '', '218.33.123.25', 'public', NULL, 'Aplikasi Supporting Server', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(214, '', '218.33.123.26', 'public', NULL, 'IP PUBLIK NEW PRO 1', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(215, '', '218.33.123.27', 'public', NULL, 'IP PUBLIK NEW PRO 2', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(216, '', '218.33.123.28', 'public', NULL, 'IP PUBLIK NEW PRO 4', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(217, '', '218.33.123.29', 'public', NULL, 'Global Media Academy', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(218, '', '218.33.123.30', 'public', NULL, 'Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(219, '', '218.33.123.31', 'public', NULL, 'Aplikasi PNBP NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(220, '', '218.33.123.32', 'public', NULL, 'Aplikasi PNet Lab', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(221, '', '218.33.123.33', 'public', NULL, 'IoT Siaga', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(222, '', '218.33.123.34', 'public', NULL, 'IP Extend Portal Berita RRI', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(223, '', '218.33.123.35', 'public', NULL, 'IP Private-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(224, '', '218.33.123.36', 'public', NULL, 'Aplikasi Mail Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(225, '', '218.33.123.37', 'public', NULL, 'Aplikasi Mail Gateway Corporate (rri.co.id)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(226, '', '218.33.123.38', 'public', NULL, 'Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(227, '', '218.33.123.39', 'public', NULL, 'Aplikasi WAZUH SOC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(228, '', '218.33.123.40', 'public', NULL, 'DevOps', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(229, '', '218.33.123.41', 'public', NULL, 'RRI Digital 1', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(230, '', '218.33.123.42', 'public', NULL, 'RRI Digital 2', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(231, '', '218.33.123.43', 'public', NULL, 'RRI Digital 3', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(232, '', '218.33.123.44', 'public', NULL, 'S3 RRI Digital', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(233, '', '218.33.123.45', 'public', NULL, 'NextCloud Collabora', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(234, '', '218.33.123.46', 'public', NULL, 'Docker Swarm', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(235, '', '218.33.123.47', 'public', NULL, 'My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(236, '', '218.33.123.48', 'public', NULL, 'LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(237, '', '218.33.123.49', 'public', NULL, 'MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(238, '', '218.33.123.50', 'public', NULL, 'JDIH Nginx', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(239, '', '218.33.123.51', 'public', NULL, 'Codec Backup', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(240, '', '218.33.123.52', 'public', NULL, 'H3C', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(241, '', '218.33.123.53', 'public', NULL, 'Aplikasi DIAS', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(242, '', '218.33.123.54', 'public', NULL, 'IP Router Firewall DC Jakarta', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(243, '', '218.33.123.56', 'public', NULL, 'TrueNas', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(244, '', '218.33.123.57', 'public', NULL, 'internet Gedung Sebelah (sebelumnya digunakan LPU)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(245, '', '218.33.123.58', 'public', NULL, 'CMS Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(246, '', '218.33.123.59', 'public', NULL, 'Front Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(247, '', '218.33.123.60', 'public', NULL, 'Server API Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 1),
(248, '', '218.33.123.65', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(249, '', '218.33.123.66', 'public', NULL, 'IP Router 1', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(250, '', '218.33.123.67', 'public', NULL, 'IP Router 2', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(251, '', '218.33.123.68', 'public', NULL, 'IP Server', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(252, '', '218.33.123.69', 'public', NULL, 'IP API Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(253, '', '218.33.123.70', 'public', NULL, 'IP CMS Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(254, '', '218.33.123.71', 'public', NULL, 'IP Frontend Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(255, '', '218.33.123.72', 'public', NULL, 'IP Pro 1 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(256, '', '218.33.123.73', 'public', NULL, 'IP Pro 2 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(257, '', '218.33.123.74', 'public', NULL, 'IP Pro 4 Streaming', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(258, '', '218.33.123.75', 'public', NULL, 'IP WAF DC PDN Serpong', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(259, '', '218.33.123.76', 'public', NULL, 'IP S3 Portal', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 2),
(260, '', '218.33.123.129', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 3),
(261, '', '218.33.123.130', 'public', NULL, 'IP Firewall Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 3),
(262, '', '218.33.123.131', 'public', NULL, 'IP Router Kantor Pusat', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 3),
(263, '', '218.33.123.193', 'gateway', NULL, 'Gateway', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(264, '', '218.33.123.194', 'public', NULL, 'Internet Semua Perangkat DC MBC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(265, '', '218.33.123.195', 'public', NULL, 'Aplikasi Manajemen IP', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(266, '', '218.33.123.196', 'public', NULL, 'Aplikasi Pusdatin NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(267, '', '218.33.123.197', 'public', NULL, 'Aplikasi JDIH NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(268, '', '218.33.123.198', 'public', NULL, 'IP Internet Server Aplikasi E-Learning MBC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(269, '', '218.33.123.199', 'public', NULL, 'IP Internet Server Docker MBC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(270, '', '218.33.123.200', 'public', NULL, 'T-Track Pemancar', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(271, '', '218.33.123.201', 'public', NULL, 'IP Publik Email Corporate RRI (rri.go.id)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(272, '', '218.33.123.202', 'public', NULL, 'Aplikasi DRM Proxy', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(273, '', '218.33.123.203', 'public', NULL, 'Aplikasi WAF MBC', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(274, '', '218.33.123.204', 'public', NULL, 'Aplikasi Jenkins Git Docker', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(275, '', '218.33.123.205', 'public', NULL, 'IP Router Core Operasional', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(276, '', '218.33.123.206', 'public', NULL, 'IP Publik-Streaming Video', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(277, '', '218.33.123.207', 'public', NULL, 'IP Aplikasi Logger NEW', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(278, '', '218.33.123.208', 'public', NULL, 'IP Aplikasi Simpatik (PT. Novarya)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(279, '', '218.33.123.209', 'public', NULL, 'IP My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(280, '', '218.33.123.210', 'public', NULL, 'IP LB My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(281, '', '218.33.123.211', 'public', NULL, 'IP MinIO My-Presensi Terbaru (PT. TKM)', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(282, '', '218.33.123.212', 'public', NULL, 'IP Aplikasi Presensi Mobile API Node JS', 'active', 'available', NULL, '2026-01-22 16:02:09', '2026-01-22 16:02:09', 6),
(283, '', '218.33.123.0', 'public', NULL, '', 'inactive', 'available', NULL, '2026-01-22 12:17:05', '2026-01-22 18:24:46', 1),
(284, '', '218.33.123.128', 'public', NULL, '', 'inactive', 'available', NULL, '2026-01-23 17:26:47', '2026-01-23 17:27:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_base`
--

CREATE TABLE `knowledge_base` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'General',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `views` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text,
  `attempt_time` datetime NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `failure_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `username`, `ip_address`, `user_agent`, `attempt_time`, `success`, `failure_reason`) VALUES
(1, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 18:23:35', 1, ''),
(2, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 18:56:30', 1, ''),
(3, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 18:57:49', 1, ''),
(4, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 18:57:57', 1, ''),
(5, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:01:29', 1, ''),
(6, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:03:09', 1, ''),
(7, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:03:21', 1, ''),
(8, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:19:04', 1, ''),
(9, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:54:01', 1, ''),
(10, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 19:56:43', 1, ''),
(11, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 20:08:44', 1, ''),
(12, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 20:12:36', 1, ''),
(13, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 03:58:42', 0, 'Invalid credentials'),
(14, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 03:58:50', 1, ''),
(15, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:13:41', 1, ''),
(16, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:34:46', 1, ''),
(17, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:35:04', 1, ''),
(18, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:40:01', 1, ''),
(19, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:40:27', 1, ''),
(20, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:41:35', 1, ''),
(21, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:42:42', 1, ''),
(22, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:42:42', 1, ''),
(23, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:46:51', 1, ''),
(24, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:49:00', 1, ''),
(25, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 04:54:12', 1, ''),
(26, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:02:38', 1, ''),
(27, 'Nur', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:05:52', 1, ''),
(28, 'Nur', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:06:40', 0, 'Invalid credentials'),
(29, 'Nur', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:06:50', 1, ''),
(30, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:08:23', 1, ''),
(31, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-24 05:17:32', 1, ''),
(32, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-25 16:00:47', 1, ''),
(33, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-25 16:21:20', 0, 'Invalid credentials'),
(34, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-25 16:21:29', 1, ''),
(35, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-25 16:40:39', 0, 'Invalid credentials'),
(36, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-25 16:40:44', 1, ''),
(37, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-25 17:09:08', 1, ''),
(38, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-25 18:05:31', 1, ''),
(39, 'Mashudi', '192.168.0.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-25 18:15:14', 1, ''),
(40, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 02:47:36', 1, ''),
(41, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 02:48:01', 1, ''),
(42, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 03:43:41', 1, ''),
(43, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-26 05:29:12', 1, ''),
(44, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 03:26:46', 1, ''),
(45, 'Mashudi', '192.168.233.173', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-27 03:21:42', 1, ''),
(46, 'Fahri', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 05:43:41', 1, ''),
(47, 'Mashudi', '192.168.233.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 05:43:47', 1, ''),
(48, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 08:22:41', 1, ''),
(49, 'Fahri', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 07:28:57', 1, ''),
(50, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 12:08:59', 1, ''),
(51, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:37:46', 1, ''),
(52, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:37:55', 1, ''),
(53, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:38:03', 1, ''),
(54, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:41:58', 1, ''),
(55, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:42:19', 1, ''),
(56, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:45:39', 1, ''),
(57, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:50:35', 1, ''),
(58, 'Mashudi', '::1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-27 14:51:32', 1, ''),
(59, 'Fahri', '::1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-27 14:52:11', 1, ''),
(60, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:53:48', 1, ''),
(61, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 14:59:11', 1, ''),
(62, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:05:39', 1, ''),
(63, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:11:35', 1, ''),
(64, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:15:52', 1, ''),
(65, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:18:01', 1, ''),
(66, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:19:47', 1, ''),
(67, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:23:57', 1, ''),
(68, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:26:00', 1, ''),
(69, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:26:15', 1, ''),
(70, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:26:36', 1, ''),
(71, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-27 15:28:29', 1, ''),
(72, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:22:42', 1, ''),
(73, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:23:44', 1, ''),
(74, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:24:09', 1, ''),
(75, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:30:53', 0, 'Invalid credentials'),
(76, 'Mashudii', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:31:02', 1, ''),
(77, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:47:28', 0, 'Invalid credentials'),
(78, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:47:38', 0, 'Invalid credentials'),
(79, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:47:45', 0, 'Invalid credentials'),
(80, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:47:54', 1, ''),
(81, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 02:52:06', 1, ''),
(82, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 03:09:41', 1, ''),
(83, 'Mashudi', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 03:23:33', 1, ''),
(84, 'Fahri', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 03:27:33', 1, ''),
(85, 'Fahri', '192.168.233.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-28 10:32:29', 1, ''),
(86, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 11:18:48', 1, ''),
(87, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 13:17:42', 1, ''),
(88, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 13:48:59', 1, ''),
(89, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 13:49:19', 1, ''),
(90, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 18:59:05', 0, 'Invalid credentials'),
(91, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 18:59:11', 1, ''),
(92, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 20:01:54', 1, ''),
(93, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 20:14:26', 1, ''),
(94, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:11:38', 0, 'Invalid credentials'),
(95, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:11:44', 0, 'Invalid credentials'),
(96, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:11:54', 0, 'Invalid credentials'),
(97, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:12:21', 0, 'Invalid credentials'),
(98, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:12:41', 0, 'Invalid credentials'),
(99, 'cek', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:13:43', 0, 'Rate limit exceeded (IP)'),
(100, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:25:05', 0, 'Rate limit exceeded (IP)'),
(101, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:25:21', 0, 'Rate limit exceeded (IP)'),
(102, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:27:55', 0, 'Invalid credentials'),
(103, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:28:18', 0, 'Invalid credentials'),
(104, 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:31:28', 1, ''),
(105, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 21:32:30', 1, ''),
(106, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 22:23:32', 1, ''),
(107, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-28 23:16:20', 1, ''),
(108, 'Mashudi', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-29 08:36:13', 1, ''),
(109, 'Fahri', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-01-29 08:37:11', 1, ''),
(110, 'Mashudi', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-29 08:40:34', 0, 'Invalid credentials'),
(111, 'Mashudi', '192.168.20.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-29 08:40:44', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE `networks` (
  `id` int NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cidr` varchar(45) NOT NULL,
  `range_start` varchar(45) NOT NULL,
  `range_end` varchar(45) NOT NULL,
  `subnet_mask` varchar(45) DEFAULT NULL,
  `description` text,
  `is_reserve` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`id`, `slug`, `name`, `cidr`, `range_start`, `range_end`, `subnet_mask`, `description`, `is_reserve`, `created_at`, `updated_at`) VALUES
(1, 'jakarta', 'Data Center JKT', '218.33.123.0/26', '218.33.123.0', '218.33.123.63', '255.255.255.192', 'Core Network', 0, '2026-01-22 16:00:06', '2026-01-23 03:23:18'),
(2, 'serpong', 'DC PDN Serpong', '218.33.123.64/26', '218.33.123.64', '218.33.123.127', '255.255.255.192', 'Disaster Recovery (DRC)', 0, '2026-01-22 16:00:06', '2026-01-22 16:00:06'),
(3, 'pusat', 'DC Kantor Pusat', '218.33.123.128/27', '218.33.123.128', '218.33.123.159', '255.255.255.224', 'Headquarters', 0, '2026-01-22 16:00:06', '2026-01-22 16:00:06'),
(4, 'reserve1', 'Network Cadangan 1', '218.33.123.160/28', '218.33.123.160', '218.33.123.175', '255.255.255.240', 'Dapat digunakan untuk: IP Transit', 1, '2026-01-22 16:00:06', '2026-01-24 04:26:29'),
(5, 'reserve2', 'Network Cadangan 2', '218.33.123.176/28', '218.33.123.176', '218.33.123.191', '255.255.255.240', 'Future DC / Event / Kebutuhan Dadakan', 1, '2026-01-22 16:00:06', '2026-01-22 16:00:06'),
(6, 'depok', 'DC Depok', '218.33.123.192/26', '218.33.123.192', '218.33.123.255', '255.255.255.192', 'Data Center', 0, '2026-01-22 16:00:06', '2026-01-22 16:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `server_credentials`
--

CREATE TABLE `server_credentials` (
  `id` int UNSIGNED NOT NULL,
  `vm_name` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `description` text,
  `domain` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `server_credentials`
--

INSERT INTO `server_credentials` (`id`, `vm_name`, `ip_address`, `username`, `password`, `description`, `domain`, `created_at`, `updated_at`) VALUES
(1, 'Absensi MinIO 1', '10.30.1.131', 'absensi_minio1', 'Lpprri_@1945', 'MinIO', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(2, 'Absensi Node JS', '10.30.1.135', 'absensi_node.js', 'Lpprri_@1945', 'Laravel', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(3, 'Absensi DB 1', '10.30.1.136', 'absensi_db1', 'Lpprri_@1945', 'apache2', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(4, 'Absensi Web 1', '10.30.1.138', 'absensi_web1', 'Lpprri_@1945', 'php 8.2 mysql 8.0 phpmyadmin', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(5, 'Absensi Web 2', '10.30.1.139', 'absensi_web2', 'Lpprri_@1945', 'Nginx', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(6, 'Ip Publik pertama', '182.16.253.140', '', '', 'Php 8.2', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(7, 'IP publik kedua', '182.16.253.141', '', '', 'Mysql - client', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(8, 'PHPMYADMIN DB', '', 'root', 'Lpprri_@1945', 'Stack LAMP', 'http://10.30.1.136/phpmyadmin/index.php?route=/', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(9, 'MINIO S3 Storage', '', 'admin', 'Lpprri_@1945', '', 'http://10.30.1.131:9001/login', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(10, 'Akses VPN ke Server DC RRI', '36.93.159.51', 'basrul', 'lpprri45', 'L2TP + IPSec', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(11, 'Firewal Fortigate (Web GUI)', '10.30.1.254', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(12, 'DC RRI Jakarta', '10.30.1.101:8006', 'michael, sarah, ade, randy', 'AyamGoreng-MasBudiEn@k', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(13, 'DC MBC Depok', '10.30.6.3:8006', 'sarah, michael, ade (nama)', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(14, 'Berbagi Pakai', '10.30.9.20', 'direktorat_tmb/admin/TMB/tmb', 'lpprri1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(15, 'Worker2docker', '10.30.1.247', 'worker2', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(16, 'Portainer untuk Master Worker dan Load Balancer Docker', '10.30.1.167:9443', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(17, 'Portainer untuk Master Worker dan Load Balancer Docker', '10.30.1.221', 'admin', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(18, 'Mikrotik Astinet Operasional (Winbox & SSH)', '10.99.99.1:1200', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(19, 'Mikrotik Core Operasional (Winbox & SSH)', '10.4.4.1:1500', 'sarah, michael, ade (nama)', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(20, 'Mikrotik Kantor Pusat (Winbox & SSH)', '10.4.4.2:1400', 'randy', 'lpprri45', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(21, 'Mikrotik VPN Tunnel (Winbox & SSH)', '10.7.7.1:1800', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(22, 'Set PHPIPAM', '10.30.9.46:8080', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(23, 'Portainer untuk docker PHPIPAM', '10.30.9.46:9443', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(24, 'Safeline WAF untuk PHPIPAM', '10.30.9.46:9445', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(25, 'Proxy Media DAP', '10.30.1.114', 'root', '@@@R00T4server@@@', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(26, 'Zabbix', '10.30.1.15', 'achmad', 'zabbix', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(27, 'Backup Email Coorporate', '10.30.1.149', 'corp-app-backup', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(28, 'DRM Proxy local', '10.30.1.235', 'root', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(29, 'DRM Proxy publik', '182.16.253.177', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(30, 'IP Publik node js', '182.16.253.78', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(31, 'lb presensi tkm', '10.30.1.236', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(32, 'Redish Absen TKM', '10.30.1.237', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(33, 'SOC', '10.30.1.238', 'soc-rri', 'Lpprri_@1945', 'soc-wazuh', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(34, 'SOC', '10.30.1.239', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(35, 'IP VM Hafidzh', '10.30.1.240', '', '', '', '10.30.9.22', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(36, 'SOC', '10.30.1.241', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(37, 'Radio Logger', '10.30.1.242', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(38, 'safeline JKT', 'waf-jkt.rri.go.id', 'michael', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(39, 'safeline depok', 'waf-mbc.rri.go.id', 'michael', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(40, 'Proxmox DC Manager', 'https://10.30.1.130:8443', 'root', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(41, 'SOC', 'https://10.30.1.233', 'admin', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(42, 'SSH SOC', '10.30.1.233', 'soc-rri', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(43, 'DNS Interlink', '203.171.221.34', '', '', 'nano /etc/resolv.conf\nsystemctl restart resolv.conf', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(44, 'DNS Interlink', '203.171.221.35', '', '', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(45, 'Private Streaming', '10.30.1.221', 'admin', 'Lpprri_@1945', '', 'https://10.30.1.221:9443', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(46, 'pusdatin lb', '10.30.1.242', 'pusdatin_lb', 'Lpprri_@1945', '', 'pusdatin.rri.go.id', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(47, 'pusdatin_db', '10.30.1.245', 'pusdatin_db', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(48, 'pusdatin_web1', '10.30.1.243', 'pusdatin_web1', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(49, 'pusdatin_web2', '10.30.1.244', 'pusdatin_web2', 'Lpprri_@1945', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(50, 'unifi network', '10.30.1.13:8443', '', '', '', 'https://10.30.1.13:8443', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(51, 'proxmox ve wat', '10.180.180.131:8006', 'root', 'P@ssw0rd.1', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38'),
(52, 'waf mbc', '', 'admin', 'HSnTgKOH', '', '', '2026-01-27 05:07:38', '2026-01-27 05:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  `input_type` varchar(50) DEFAULT 'text',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `input_type`, `updated_at`) VALUES
(1, 'site_title', 'CSIRT RRI', 'general', 'text', '2026-01-23 08:41:36'),
(2, 'site_description', 'Computer Security Incident Response Team LPP RRI', 'general', 'textarea', '2026-01-23 08:41:36'),
(3, 'contact_email', 'csirt@rri.go.id', 'general', 'email', '2026-01-23 08:41:36'),
(4, 'contact_phone', '+62 21 12345678', 'general', 'text', '2026-01-23 08:41:36'),
(5, 'footer_text', '&copy; 2026 RRI CSIRT. All rights reserved.', 'general', 'text', '2026-01-23 08:41:36'),
(6, 'enable_waf_stats', '1', 'security', 'toggle', '2026-01-23 08:41:36'),
(7, 'waf_api_url', 'https://trial-waf.rri.go.id/api/commercial/record/export', 'security', 'text', '2026-01-23 08:41:36'),
(8, 'waf_api_token', '', 'security', 'password', '2026-01-23 08:41:36'),
(9, 'max_login_attempts', '5', 'security', 'number', '2026-01-23 08:41:36'),
(10, 'maintenance_mode', '0', 'security', 'toggle', '2026-01-23 08:41:36'),
(11, 'social_facebook', '#', 'social', 'text', '2026-01-23 08:41:36'),
(12, 'social_twitter', '#', 'social', 'text', '2026-01-23 08:41:36'),
(13, 'social_instagram', '#', 'social', 'text', '2026-01-23 08:41:36'),
(14, 'waf_api_username', 'admin', 'api', 'text', '2026-01-23 13:44:55'),
(15, 'waf_api_password', '', 'api', 'password', '2026-01-23 13:44:55'),
(16, 'session_timeout', '7200', 'security', 'number', '2026-01-23 23:55:37'),
(17, 'login_lockout_duration', '900', 'security', 'number', '2026-01-23 23:55:37'),
(18, 'enable_2fa', '0', 'security', 'toggle', '2026-01-23 23:55:37'),
(19, 'password_min_length', '8', 'security', 'number', '2026-01-23 23:55:37'),
(20, 'password_require_uppercase', '1', 'security', 'toggle', '2026-01-23 23:55:37'),
(21, 'password_require_number', '1', 'security', 'toggle', '2026-01-23 23:55:37'),
(22, 'password_require_special', '1', 'security', 'toggle', '2026-01-23 23:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `division` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'member',
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `position`, `division`, `photo`, `email`, `phone`, `role`, `display_order`, `is_active`, `created_at`) VALUES
(30, 'Yatno', 'IT & Distribution', 'Tim IT', NULL, NULL, NULL, 'leader', 0, 1, '2026-01-27 02:44:48'),
(31, 'Achmad S.D.', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:45:28'),
(32, 'Randy A.P.', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:45:59'),
(33, 'Ade Solihin', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:46:06'),
(34, 'Michael S', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:46:17'),
(35, 'Sarah Putri T', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:46:30'),
(36, 'Farras F', 'Anggota', 'Tim IT', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:46:41'),
(37, 'Mugiamano', 'Media Baru', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'leader', 0, 1, '2026-01-27 02:47:12'),
(38, 'M Subur', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:47:39'),
(39, 'Yudha Panca', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:47:50'),
(40, 'M. Faizal', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:48:02'),
(41, 'Dema Arief', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:48:15'),
(42, 'Andrea S.', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:48:29'),
(43, 'M. Rizki Azizi', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:48:44'),
(44, 'M. Dhiya', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:48:58'),
(45, 'Ali Syauqi', 'Anggota', 'Tim Teknologi Media Baru', NULL, NULL, NULL, 'member', 0, 1, '2026-01-27 02:49:09'),
(47, 'M Sujai', 'Direktur TMB', 'Direksi', NULL, NULL, NULL, 'director', 0, 1, '2026-01-28 07:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','management','auditor','analyst','user','superadmin') DEFAULT 'user',
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `failed_login_attempts` int DEFAULT '0',
  `account_locked_until` datetime DEFAULT NULL,
  `login_ip` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `is_deleted` tinyint(1) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `full_name`, `phone`, `is_active`, `last_login`, `last_activity`, `failed_login_attempts`, `account_locked_until`, `login_ip`, `created_at`, `updated_at`, `avatar`, `status`, `is_deleted`, `deleted_at`) VALUES
(5, 'Nur', 'nur@gmail.com', '$2y$10$yh1gPBrUipgIarz7ToUA3OoMUXWFN.9mGgEHIITKwD0iVpsj74GLG', 'auditor', NULL, NULL, 1, '2026-01-24 11:08:08', '2026-01-24 11:08:08', 0, NULL, '::1', '2026-01-22 20:32:15', '2026-01-28 14:31:37', 'avatar_1769110335.jpg', 'active', 1, '2026-01-28 14:31:37'),
(8, 'cek', 'cek@gmail.com', '$2y$10$yzJvhD31EW6igfT00MIX9uwh0PYV6Wk2mzz4yUu/oo0yR5frXm/De', 'admin', NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, '2026-01-28 20:55:28', '2026-01-28 14:31:41', 'default_avatar.png', 'active', 1, '2026-01-28 14:31:41'),
(10, 'admin', 'admin@rrisoc.id', '$2y$10$BwGfCU5njJMtWHqJxYJwa.9TlJTx0uus5ACtbKryO1olu0YbeUR22', 'admin', NULL, NULL, 1, '2026-01-28 21:31:28', NULL, 0, NULL, '::1', '2026-01-28 21:29:13', '2026-01-29 01:36:31', NULL, 'active', 1, '2026-01-29 01:36:31'),
(11, 'Mashudi', 'mashudi@gmail.com', '$2y$10$yD6mMWEkCwIX3zK81cSkFeCmph32tChx2MYPMjJP0tem8E8yuURX.', 'admin', NULL, NULL, 1, '2026-01-29 08:40:44', NULL, 0, NULL, '192.168.20.33', '2026-01-28 21:32:17', '2026-01-29 01:46:01', 'avatar_1769610737.png', 'active', 0, NULL),
(12, 'Fahri', 'fahri@gmail.com', '$2y$10$6MYRETVOnE9CvKtGkQNCXeOJyz/82uvMalsDH/rmsNRFagOuGiWuO', 'auditor', NULL, NULL, 1, '2026-01-29 08:37:11', '2026-01-29 08:45:52', 0, NULL, '::1', '2026-01-29 08:36:50', '2026-01-29 01:45:52', 'default_avatar.png', 'active', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vpn_allocation`
--

CREATE TABLE `vpn_allocation` (
  `id` int UNSIGNED NOT NULL,
  `satker` varchar(255) NOT NULL,
  `ip_lan` varchar(100) DEFAULT NULL,
  `ip_vpn` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'offline',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `vpn_allocation`
--

INSERT INTO `vpn_allocation` (`id`, `satker`, `ip_lan`, `ip_vpn`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RRI Jakarta', '10.30.1.0/24', '10.7.7.2', 'offline', '2026-01-28 03:35:11', NULL),
(2, 'RRI Bengkulu', '172.16.88.0/24', '172.16.6.22', 'offline', '2026-01-28 03:35:11', NULL),
(3, 'RRI Tanjung Pinang', '172.16.89.0/24', '172.16.6.49', 'offline', '2026-01-28 03:35:11', NULL),
(4, 'RRI Ternate', '172.16.92.0/24', '172.16.6.35', 'offline', '2026-01-28 03:35:11', NULL),
(5, 'RRI Pekanbaru', '172.16.95.0/24', '172.16.6.12', 'offline', '2026-01-28 03:35:11', NULL),
(6, 'RRI Mamuju', '172.16.97.0/24', '172.16.6.68', 'offline', '2026-01-28 03:35:11', NULL),
(7, 'RRI Banda Aceh', '192.168.3.0/24', '172.16.6.27', 'offline', '2026-01-28 03:35:11', NULL),
(8, 'RRI Bandar Lampung', '192.168.4.0/24', '172.16.6.23', 'offline', '2026-01-28 03:35:11', NULL),
(9, 'RRI Padang', '192.168.7.0/24', '172.16.6.5', 'offline', '2026-01-28 03:35:11', NULL),
(10, 'RRI Nunukan', '192.168.8.0/24', '172.16.6.57', 'offline', '2026-01-28 03:35:11', NULL),
(11, 'RRI Palembang', '192.168.9.0/24', '172.16.6.16', 'offline', '2026-01-28 03:35:11', NULL),
(12, 'RRI Bogor', '192.168.12.0/24', '172.16.6.38', 'offline', '2026-01-28 03:35:11', NULL),
(13, 'RRI Makassar', '192.168.32.0/24', '172.16.6.20', 'offline', '2026-01-28 03:35:11', NULL),
(14, 'RRI Tual', '192.168.37.0/24', '172.16.6.52', 'offline', '2026-01-28 03:35:11', NULL),
(15, 'RRI Lhokseumawe', '192.168.48.0/24', '172.16.6.36', 'offline', '2026-01-28 03:35:11', NULL),
(16, 'RRI Meulaboh', '192.168.49.0/24', '172.16.6.79', 'offline', '2026-01-28 03:35:11', NULL),
(17, 'Stasiun Luar Negeri', '192.168.50.0/24', '10.7.7.2', 'offline', '2026-01-28 03:35:11', NULL),
(18, 'RRI Surakarta', '192.168.51.0/24', '172.16.6.41', 'offline', '2026-01-28 03:35:11', NULL),
(19, 'RRI Sibolga', '192.168.52.0/24', '172.16.6.53', 'offline', '2026-01-28 03:35:11', NULL),
(20, 'RRI Bukittinggi', '192.168.53.0/24', '172.16.6.37', 'offline', '2026-01-28 03:35:11', NULL),
(21, 'RRI Jambi', '192.168.55.0/24', '172.16.6.25', 'offline', '2026-01-28 03:35:11', NULL),
(22, 'RRI Sungailiat', '192.168.59.0/24', '172.16.6.33', 'offline', '2026-01-28 03:35:11', NULL),
(23, 'RRI Ranai', '192.168.60.0/24', '172.16.6.60', 'offline', '2026-01-28 03:35:11', NULL),
(24, 'RRI Cirebon', '192.168.61.0/24', '172.16.6.39', 'offline', '2026-01-28 03:35:11', NULL),
(25, 'RRI Semarang', '192.168.62.0/24', '172.16.6.18', 'offline', '2026-01-28 03:35:11', NULL),
(26, 'RRI Belitung Timur', '192.168.63.0/24', '172.16.6.94', 'offline', '2026-01-28 03:35:11', NULL),
(27, 'RRI Purwokerto', '192.168.64.0/24', '172.16.6.40', 'offline', '2026-01-28 03:35:11', NULL),
(28, 'RRI Surabaya', '192.168.65.0/24', '172.16.6.19', 'offline', '2026-01-28 03:35:11', NULL),
(29, 'RRI Madiun', '192.168.66.0/24', '172.16.6.43', 'offline', '2026-01-28 03:35:11', NULL),
(30, 'RRI Malang', '192.168.67.0/24', '172.16.6.44', 'offline', '2026-01-28 03:35:11', NULL),
(31, 'RRI Sumenep', '192.168.69.0/24', '172.16.6.46', 'offline', '2026-01-28 03:35:11', NULL),
(32, 'RRI Denpasar', '192.168.71.0/24', '172.16.6.9', 'offline', '2026-01-28 03:35:11', NULL),
(33, 'RRI Mataram', '192.168.73.0/24', '172.16.6.30', 'offline', '2026-01-28 03:35:11', NULL),
(34, 'RRI Kupang', '192.168.74.0/24', '172.16.6.24', 'offline', '2026-01-28 03:35:11', NULL),
(35, 'RRI Ende', '192.168.75.0/24', '172.16.6.55', 'offline', '2026-01-28 03:35:11', NULL),
(36, 'RRI Atambua', '192.168.76.0/24', '172.16.6.56', 'offline', '2026-01-28 03:35:11', NULL),
(37, 'RRI Pontianak', '192.168.77.0/24', '172.16.6.26', 'offline', '2026-01-28 03:35:11', NULL),
(38, 'RRI Sintang', '192.168.78.0/24', '172.16.6.54', 'offline', '2026-01-28 03:35:11', NULL),
(39, 'RRI Singaraja', '192.168.79.0/24', '172.16.6.45', 'offline', '2026-01-28 03:35:11', NULL),
(40, 'RRI Palangkaraya', '192.168.80.0/24', '172.16.6.32', 'offline', '2026-01-28 03:35:11', NULL),
(41, 'RRI Samarinda', '192.168.81.0/24', '172.16.6.28', 'offline', '2026-01-28 03:35:11', NULL),
(42, 'RRI Banjarmasin', '192.168.82.0/24', '172.16.6.14', 'offline', '2026-01-28 03:35:11', NULL),
(43, 'RRI Boven Digoel', '192.168.83.0/24', '172.16.6.89', 'offline', '2026-01-28 03:35:11', NULL),
(44, 'RRI Manado', '192.168.84.0/24', '172.16.6.13', 'offline', '2026-01-28 03:35:11', NULL),
(45, 'RRI Entikong', '192.168.85.0/24', '172.16.6.90', 'offline', '2026-01-28 03:35:11', NULL),
(46, 'RRI Gorontalo', '192.168.86.0/24', '172.16.6.34', 'offline', '2026-01-28 03:35:11', NULL),
(47, 'RRI Merauke', '192.168.87.0/24', '172.16.6.91', 'offline', '2026-01-28 03:35:11', NULL),
(48, 'RRI Kendari', '192.168.89.0/24', '172.16.6.31', 'offline', '2026-01-28 03:35:11', NULL),
(49, 'RRI Ambon', '192.168.90.0/24', '172.16.6.29', 'offline', '2026-01-28 03:35:11', NULL),
(50, 'RRI Sendawar', '192.168.91.0/24', '172.16.6.92', 'offline', '2026-01-28 03:35:11', NULL),
(51, 'RRI FakFak', '192.168.92.0/24', '172.16.6.50', 'offline', '2026-01-28 03:35:11', NULL),
(52, 'RRI Sorong', '192.168.93.0/24', '172.16.6.47', 'offline', '2026-01-28 03:35:11', NULL),
(53, 'RRI Jayapura', '192.168.94.0/24', '172.16.6.8', 'offline', '2026-01-28 03:35:11', NULL),
(54, 'RRI Rote', '192.168.95.0/24', '172.16.6.93', 'offline', '2026-01-28 03:35:11', NULL),
(55, 'RRI Biak', '192.168.96.0/24', '172.16.6.48', 'offline', '2026-01-28 03:35:11', NULL),
(56, 'RRI Nabire', '192.168.97.0/24', '172.16.6.62', 'offline', '2026-01-28 03:35:11', NULL),
(57, 'RRI Manokwari', '192.168.98.0/24', '172.16.6.21', 'offline', '2026-01-28 03:35:11', NULL),
(58, 'RRI Saumlaki', '192.168.101.0/24', '172.16.6.100', 'offline', '2026-01-28 03:35:11', NULL),
(59, 'RRI Tuban', '192.168.152.0/24', '172.16.6.83', 'offline', '2026-01-28 03:35:11', NULL),
(60, 'RRI Takengon', '192.168.153.0/24', '172.16.6.58', 'offline', '2026-01-28 03:35:11', NULL),
(61, 'RRI Bintuhan', '192.168.154.0/24', '172.16.6.71', 'offline', '2026-01-28 03:35:11', NULL),
(62, 'RRI Labuan Bajo', '192.168.155.0/24', '172.16.6.75', 'offline', '2026-01-28 03:35:11', NULL),
(63, 'RRI Sambas', '192.168.156.0/24', '172.16.6.80', 'offline', '2026-01-28 03:35:11', NULL),
(64, 'RRI Sanggau', '192.168.157.0/24', '172.16.6.81', 'offline', '2026-01-28 03:35:11', NULL),
(65, 'RRI Baubau', '192.168.158.0/24', '172.16.6.65', 'offline', '2026-01-28 03:35:11', NULL),
(66, 'RRI Toli-toli', '192.168.165.0/24', '172.168.165.0/24', 'offline', '2026-01-28 03:35:11', NULL),
(67, 'RRI Yogyakarta', '192.168.170.0/24', '172.16.6.17', 'offline', '2026-01-28 03:35:11', NULL),
(68, 'RRI Bener Meriah', '192.168.171.0/24', '172.16.6.69', 'offline', '2026-01-28 03:35:11', NULL),
(69, 'RRI Way Kanan', '192.168.172.0/24', '172.16.6.84', 'offline', '2026-01-28 03:35:11', NULL),
(70, 'RRI Sumba', '192.168.173.0/24', '172.16.6.77', 'offline', '2026-01-28 03:35:11', NULL),
(71, 'RRI Sabang', '192.168.174.0/24', '172.16.6.78', 'offline', '2026-01-28 03:35:11', NULL),
(72, 'RRI Sungai Penuh', '192.168.176.0/24', '172.16.6.82', 'offline', '2026-01-28 03:35:11', NULL),
(73, 'RRI Sampang', '192.168.177.0/24', '172.16.6.70', 'offline', '2026-01-28 03:35:11', NULL),
(74, 'RRI Ampana', '192.168.178.0/24', '172.16.6.85', 'offline', '2026-01-28 03:35:11', NULL),
(75, 'RRI Tanjung Balai', '192.168.179.0/24', '172.16.6.86', 'offline', '2026-01-28 03:35:11', NULL),
(76, 'RRI Bula', '192.168.180.0/24', '172.16.6.95', 'offline', '2026-01-28 03:35:11', NULL),
(77, 'RRI Bima', '192.168.181.0/24', '172.16.6.76', 'offline', '2026-01-28 03:35:11', NULL),
(78, 'RRI Kediri', '192.168.182.0/24', '172.16.6.74', 'offline', '2026-01-28 03:35:11', NULL),
(79, 'RRI Bengkalis', '192.168.183.0/24', '172.16.6.73', 'offline', '2026-01-28 03:35:11', NULL),
(80, 'RRI Alor', '192.168.184.0/24', '172.16.6.64', 'offline', '2026-01-28 03:35:11', NULL),
(81, 'RRI Bone', '192.168.185.0/24', '172.16.6.72', 'offline', '2026-01-28 03:35:11', NULL),
(82, 'RRI Malinau', '192.168.186.0/24', '172.16.6.67', 'offline', '2026-01-28 03:35:11', NULL),
(83, 'RRI Batam', '192.168.187.0/24', '172.16.6.59', 'offline', '2026-01-28 03:35:11', NULL),
(84, 'RRI Serui', '192.168.188.0/24', '172.16.6.51', 'offline', '2026-01-28 03:35:11', NULL),
(85, 'RRI Tahuna', '192.168.189.0/24', '172.16.6.87', 'offline', '2026-01-28 03:35:11', NULL),
(86, 'RRI Wamena', '192.168.190.0/24', '172.16.6.88', 'offline', '2026-01-28 03:35:11', NULL),
(87, 'RRI Tarakan', '192.168.199.0/24', '172.16.6.7', 'offline', '2026-01-28 03:35:11', NULL),
(88, 'RRI Gunungsitoli', '192.168.200.0/24', '172.16.6.61', 'offline', '2026-01-28 03:35:11', NULL),
(89, 'RRI Talaud', '192.168.205.0/24', '172.16.6.96', 'offline', '2026-01-28 03:35:11', NULL),
(90, 'RRI Nias Selatan', '192.168.240.0/24', '172.16.6.98', 'offline', '2026-01-28 03:35:11', NULL),
(91, 'RRI Kaimana', '192.168.241.0/24', '172.16.6.99', 'offline', '2026-01-28 03:35:11', NULL),
(92, 'RRI Jember', '192.168.249.0/24', '172.16.6.42', 'offline', '2026-01-28 03:35:11', NULL),
(93, 'RRI Nusantara', '192.168.250.0/24', '172.16.6.11', 'offline', '2026-01-28 03:35:11', NULL),
(94, 'RRI Palu', '192.168.251.0/24', '172.16.6.6', 'offline', '2026-01-28 03:35:11', NULL),
(95, 'RRI SPI', '192.168.252.0/24', '172.16.5.6', 'offline', '2026-01-28 03:35:11', NULL),
(96, 'RRI Bandung', '192.168.253.0/24', '172.16.6.4', 'offline', '2026-01-28 03:35:11', NULL),
(97, 'RRI Medan', '192.168.254.0/24', '172.16.6.15', 'offline', '2026-01-28 03:35:11', NULL),
(98, 'RRI Bintuni', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(99, 'RRI Oksibil', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(100, 'RRI Skow', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(101, 'RRI Miangas', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(102, 'Long Bangun', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(103, 'RRI Singkil', '', '', 'offline', '2026-01-28 03:35:11', NULL),
(104, 'Pusat Pemberitaan', '', '', 'offline', '2026-01-28 03:35:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vpn_allocations`
--

CREATE TABLE `vpn_allocations` (
  `id` int NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `network_lan` varchar(255) NOT NULL,
  `gateway_ip_remote` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vpn_allocations`
--

INSERT INTO `vpn_allocations` (`id`, `unit_name`, `network_lan`, `gateway_ip_remote`, `created_at`, `updated_at`) VALUES
(1, 'RRI Jakarta', '10.30.1.0/24', '10.7.7.2', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(2, 'RRI Bengkulu', '172.16.88.0/24', '172.16.6.22', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(3, 'RRI Tanjung Pinang', '172.16.89.0/24', '172.16.6.49', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(4, 'RRI Ternate', '172.16.92.0/24', '172.16.6.35', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(5, 'RRI Pekanbaru', '172.16.95.0/24', '172.16.6.12', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(6, 'RRI Mamuju', '172.16.97.0/24', '172.16.6.68', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(7, 'RRI Banda Aceh', '192.168.3.0/24', '172.16.6.27', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(8, 'RRI Bandar Lampung', '192.168.4.0/24', '172.16.6.23', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(9, 'RRI Padang', '192.168.7.0/24', '172.16.6.5', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(10, 'RRI Nunukan', '192.168.8.0/24', '172.16.6.57', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(11, 'RRI Palembang', '192.168.9.0/24', '172.16.6.16', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(12, 'RRI Bogor', '192.168.12.0/24', '172.16.6.38', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(13, 'RRI Makassar', '192.168.32.0/24', '172.16.6.20', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(14, 'RRI Tual', '192.168.37.0/24', '172.16.6.52', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(15, 'RRI Lhokseumawe', '192.168.48.0/24', '172.16.6.36', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(16, 'RRI Meulaboh', '192.168.49.0/24', '172.16.6.79', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(17, 'Stasiun Luar Negeri', '192.168.50.0/24', '10.7.7.2', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(18, 'RRI Surakarta', '192.168.51.0/24', '172.16.6.41', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(19, 'RRI Sibolga', '192.168.52.0/24', '172.16.6.53', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(20, 'RRI Bukittinggi', '192.168.53.0/24', '172.16.6.37', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(21, 'RRI Jambi', '192.168.55.0/24', '172.16.6.25', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(22, 'RRI Sungailiat', '192.168.59.0/24', '172.16.6.33', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(23, 'RRI Ranai', '192.168.60.0/24', '172.16.6.60', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(24, 'RRI Cirebon', '192.168.61.0/24', '172.16.6.39', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(25, 'RRI Semarang', '192.168.62.0/24', '172.16.6.18', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(26, 'RRI Belitung Timur', '192.168.63.0/24', '172.16.6.94', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(27, 'RRI Purwokerto', '192.168.64.0/24', '172.16.6.40', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(28, 'RRI Surabaya', '192.168.65.0/24', '172.16.6.19', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(29, 'RRI Madiun', '192.168.66.0/24', '172.16.6.43', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(30, 'RRI Malang', '192.168.67.0/24', '172.16.6.44', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(31, 'RRI Sumenep', '192.168.69.0/24', '172.16.6.46', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(32, 'RRI Denpasar', '192.168.71.0/24', '172.16.6.9', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(33, 'RRI Mataram', '192.168.73.0/24', '172.16.6.30', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(34, 'RRI Kupang', '192.168.74.0/24', '172.16.6.24', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(35, 'RRI Ende', '192.168.75.0/24', '172.16.6.55', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(36, 'RRI Atambua', '192.168.76.0/24', '172.16.6.56', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(37, 'RRI Pontianak', '192.168.77.0/24', '172.16.6.26', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(38, 'RRI Sintang', '192.168.78.0/24', '172.16.6.54', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(39, 'RRI Singaraja', '192.168.79.0/24', '172.16.6.45', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(40, 'RRI Palangkaraya', '192.168.80.0/24', '172.16.6.32', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(41, 'RRI Samarinda', '192.168.81.0/24', '172.16.6.28', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(42, 'RRI Banjarmasin', '192.168.82.0/24', '172.16.6.14', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(43, 'RRI Boven Digoel', '192.168.83.0/24', '172.16.6.89', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(44, 'RRI Manado', '192.168.84.0/24', '172.16.6.13', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(45, 'RRI Entikong', '192.168.85.0/24', '172.16.6.90', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(46, 'RRI Gorontalo', '192.168.86.0/24', '172.16.6.34', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(47, 'RRI Merauke', '192.168.87.0/24', '172.16.6.91', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(48, 'RRI Kendari', '192.168.89.0/24', '172.16.6.31', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(49, 'RRI Ambon', '192.168.90.0/24', '172.16.6.29', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(50, 'RRI Sendawar', '192.168.91.0/24', '172.16.6.92', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(51, 'RRI FakFak', '192.168.92.0/24', '172.16.6.50', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(52, 'RRI Sorong', '192.168.93.0/24', '172.16.6.47', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(53, 'RRI Jayapura', '192.168.94.0/24', '172.16.6.8', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(54, 'RRI Rote', '192.168.95.0/24', '172.16.6.93', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(55, 'RRI Biak', '192.168.96.0/24', '172.16.6.48', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(56, 'RRI Nabire', '192.168.97.0/24', '172.16.6.62', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(57, 'RRI Manokwari', '192.168.98.0/24', '172.16.6.21', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(58, 'RRI Saumlaki', '192.168.101.0/24', '172.16.6.100', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(59, 'RRI Tuban', '192.168.152.0/24', '172.16.6.83', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(60, 'RRI Takengon', '192.168.153.0/24', '172.16.6.58', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(61, 'RRI Bintuhan', '192.168.154.0/24', '172.16.6.71', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(62, 'RRI Labuan Bajo', '192.168.155.0/24', '172.16.6.75', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(63, 'RRI Sambas', '192.168.156.0/24', '172.16.6.80', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(64, 'RRI Sanggau', '192.168.157.0/24', '172.16.6.81', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(65, 'RRI Baubau', '192.168.158.0/24', '172.16.6.65', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(66, 'RRI Toli-toli', '192.168.165.0/24', '172.168.165.0/24', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(67, 'RRI Yogyakarta', '192.168.170.0/24', '172.16.6.17', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(68, 'RRI Bener Meriah', '192.168.171.0/24', '172.16.6.69', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(69, 'RRI Way Kanan', '192.168.172.0/24', '172.16.6.84', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(70, 'RRI Sumba', '192.168.173.0/24', '172.16.6.77', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(71, 'RRI Sabang', '192.168.174.0/24', '172.16.6.78', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(72, 'RRI Sungai Penuh', '192.168.176.0/24', '172.16.6.82', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(73, 'RRI Sampang', '192.168.177.0/24', '172.16.6.70', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(74, 'RRI Ampana', '192.168.178.0/24', '172.16.6.85', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(75, 'RRI Tanjung Balai', '192.168.179.0/24', '172.16.6.86', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(76, 'RRI Bula', '192.168.180.0/24', '172.16.6.95', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(77, 'RRI Bima', '192.168.181.0/24', '172.16.6.76', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(78, 'RRI Kediri', '192.168.182.0/24', '172.16.6.74', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(79, 'RRI Bengkalis', '192.168.183.0/24', '172.16.6.73', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(80, 'RRI Alor', '192.168.184.0/24', '172.16.6.64', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(81, 'RRI Bone', '192.168.185.0/24', '172.16.6.72', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(82, 'RRI Malinau', '192.168.186.0/24', '172.16.6.67', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(83, 'RRI Batam', '192.168.187.0/24', '172.16.6.59', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(84, 'RRI Serui', '192.168.188.0/24', '172.16.6.51', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(85, 'RRI Tahuna', '192.168.189.0/24', '172.16.6.87', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(86, 'RRI Wamena', '192.168.190.0/24', '172.16.6.88', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(87, 'RRI Tarakan', '192.168.199.0/24', '172.16.6.7', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(88, 'RRI Gunungsitoli', '192.168.200.0/24', '172.16.6.61', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(89, 'RRI Talaud', '192.168.205.0/24', '172.16.6.96', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(90, 'RRI Nias Selatan', '192.168.240.0/24', '172.16.6.98', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(91, 'RRI Kaimana', '192.168.241.0/24', '172.16.6.99', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(92, 'RRI Jember', '192.168.249.0/24', '172.16.6.42', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(93, 'RRI Nusantara', '192.168.250.0/24', '172.16.6.11', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(94, 'RRI Palu', '192.168.251.0/24', '172.16.6.6', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(95, 'RRI SPI', '192.168.252.0/24', '172.16.5.6', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(96, 'RRI Bandung', '192.168.253.0/24', '172.16.6.4', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(97, 'RRI Medan', '192.168.254.0/24', '172.16.6.15', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(98, 'RRI Bintuni', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(99, 'RRI Oksibil', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(100, 'RRI Skow', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(101, 'RRI Miangas', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(102, 'Long Bangun', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(103, 'RRI Singkil', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51'),
(104, 'Pusat Pemberitaan', '', '', '2026-01-27 06:16:51', '2026-01-27 06:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `vpn_ips`
--

CREATE TABLE `vpn_ips` (
  `id` int NOT NULL,
  `satker` varchar(255) NOT NULL,
  `ip_lan` varchar(100) DEFAULT NULL,
  `ip_vpn` varchar(100) DEFAULT NULL,
  `status` enum('online','offline') DEFAULT 'offline',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vpn_ips`
--

INSERT INTO `vpn_ips` (`id`, `satker`, `ip_lan`, `ip_vpn`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RRI Jakarta', '10.30.1.0/24', '10.7.7.2', 'online', '2026-01-28 10:15:16', '2026-01-28 10:24:09'),
(2, 'RRI Bengkulu', '172.16.88.0/24', '172.16.6.22', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(3, 'RRI Tanjung Pinang', '172.16.89.0/24', '172.16.6.49', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(4, 'RRI Ternate', '172.16.92.0/24', '172.16.6.35', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(5, 'RRI Pekanbaru', '172.16.95.0/24', '172.16.6.12', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(6, 'RRI Mamuju', '172.16.97.0/24', '172.16.6.68', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(7, 'RRI Banda Aceh', '192.168.3.0/24', '172.16.6.27', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(8, 'RRI Bandar Lampung', '192.168.4.0/24', '172.16.6.23', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(9, 'RRI Padang', '192.168.7.0/24', '172.16.6.5', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(10, 'RRI Nunukan', '192.168.8.0/24', '172.16.6.57', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(11, 'RRI Palembang', '192.168.9.0/24', '172.16.6.16', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(12, 'RRI Bogor', '192.168.12.0/24', '172.16.6.38', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(13, 'RRI Makassar', '192.168.32.0/24', '172.16.6.20', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(14, 'RRI Tual', '192.168.37.0/24', '172.16.6.52', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(15, 'RRI Lhokseumawe', '192.168.48.0/24', '172.16.6.36', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(16, 'RRI Meulaboh', '192.168.49.0/24', '172.16.6.79', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(17, 'Stasiun Luar Negeri', '192.168.50.0/24', '10.7.7.2', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(18, 'RRI Surakarta', '192.168.51.0/24', '172.16.6.41', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(19, 'RRI Sibolga', '192.168.52.0/24', '172.16.6.53', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(20, 'RRI Bukittinggi', '192.168.53.0/24', '172.16.6.37', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(21, 'RRI Jambi', '192.168.55.0/24', '172.16.6.25', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(22, 'RRI Sungailiat', '192.168.59.0/24', '172.16.6.33', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(23, 'RRI Ranai', '192.168.60.0/24', '172.16.6.60', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(24, 'RRI Cirebon', '192.168.61.0/24', '172.16.6.39', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(25, 'RRI Semarang', '192.168.62.0/24', '172.16.6.18', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(26, 'RRI Belitung Timur', '192.168.63.0/24', '172.16.6.94', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(27, 'RRI Purwokerto', '192.168.64.0/24', '172.16.6.40', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(28, 'RRI Surabaya', '192.168.65.0/24', '172.16.6.19', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(29, 'RRI Madiun', '192.168.66.0/24', '172.16.6.43', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(30, 'RRI Malang', '192.168.67.0/24', '172.16.6.44', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(31, 'RRI Sumenep', '192.168.69.0/24', '172.16.6.46', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(32, 'RRI Denpasar', '192.168.71.0/24', '172.16.6.9', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(33, 'RRI Mataram', '192.168.73.0/24', '172.16.6.30', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(34, 'RRI Kupang', '192.168.74.0/24', '172.16.6.24', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(35, 'RRI Ende', '192.168.75.0/24', '172.16.6.55', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(36, 'RRI Atambua', '192.168.76.0/24', '172.16.6.56', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(37, 'RRI Pontianak', '192.168.77.0/24', '172.16.6.26', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(38, 'RRI Sintang', '192.168.78.0/24', '172.16.6.54', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(39, 'RRI Singaraja', '192.168.79.0/24', '172.16.6.45', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(40, 'RRI Palangkaraya', '192.168.80.0/24', '172.16.6.32', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(41, 'RRI Samarinda', '192.168.81.0/24', '172.16.6.28', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(42, 'RRI Banjarmasin', '192.168.82.0/24', '172.16.6.14', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(43, 'RRI Boven Digoel', '192.168.83.0/24', '172.16.6.89', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(44, 'RRI Manado', '192.168.84.0/24', '172.16.6.13', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(45, 'RRI Entikong', '192.168.85.0/24', '172.16.6.90', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(46, 'RRI Gorontalo', '192.168.86.0/24', '172.16.6.34', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(47, 'RRI Merauke', '192.168.87.0/24', '172.16.6.91', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(48, 'RRI Kendari', '192.168.89.0/24', '172.16.6.31', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(49, 'RRI Ambon', '192.168.90.0/24', '172.16.6.29', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(50, 'RRI Sendawar', '192.168.91.0/24', '172.16.6.92', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(51, 'RRI FakFak', '192.168.92.0/24', '172.16.6.50', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(52, 'RRI Sorong', '192.168.93.0/24', '172.16.6.47', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(53, 'RRI Jayapura', '192.168.94.0/24', '172.16.6.8', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(54, 'RRI Rote', '192.168.95.0/24', '172.16.6.93', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(55, 'RRI Biak', '192.168.96.0/24', '172.16.6.48', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(56, 'RRI Nabire', '192.168.97.0/24', '172.16.6.62', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(57, 'RRI Manokwari', '192.168.98.0/24', '172.16.6.21', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(58, 'RRI Saumlaki', '192.168.101.0/24', '172.16.6.100', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(59, 'RRI Tuban', '192.168.152.0/24', '172.16.6.83', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(60, 'RRI Takengon', '192.168.153.0/24', '172.16.6.58', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(61, 'RRI Bintuhan', '192.168.154.0/24', '172.16.6.71', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(62, 'RRI Labuan Bajo', '192.168.155.0/24', '172.16.6.75', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(63, 'RRI Sambas', '192.168.156.0/24', '172.16.6.80', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(64, 'RRI Sanggau', '192.168.157.0/24', '172.16.6.81', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(65, 'RRI Baubau', '192.168.158.0/24', '172.16.6.65', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(66, 'RRI Toli-toli', '192.168.165.0/24', '172.168.165.0/24', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(67, 'RRI Yogyakarta', '192.168.170.0/24', '172.16.6.17', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(68, 'RRI Bener Meriah', '192.168.171.0/24', '172.16.6.69', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(69, 'RRI Way Kanan', '192.168.172.0/24', '172.16.6.84', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(70, 'RRI Sumba', '192.168.173.0/24', '172.16.6.77', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(71, 'RRI Sabang', '192.168.174.0/24', '172.16.6.78', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(72, 'RRI Sungai Penuh', '192.168.176.0/24', '172.16.6.82', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(73, 'RRI Sampang', '192.168.177.0/24', '172.16.6.70', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(74, 'RRI Ampana', '192.168.178.0/24', '172.16.6.85', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(75, 'RRI Tanjung Balai', '192.168.179.0/24', '172.16.6.86', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(76, 'RRI Bula', '192.168.180.0/24', '172.16.6.95', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(77, 'RRI Bima', '192.168.181.0/24', '172.16.6.76', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(78, 'RRI Kediri', '192.168.182.0/24', '172.16.6.74', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(79, 'RRI Bengkalis', '192.168.183.0/24', '172.16.6.73', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(80, 'RRI Alor', '192.168.184.0/24', '172.16.6.64', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(81, 'RRI Bone', '192.168.185.0/24', '172.16.6.72', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(82, 'RRI Malinau', '192.168.186.0/24', '172.16.6.67', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(83, 'RRI Batam', '192.168.187.0/24', '172.16.6.59', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(84, 'RRI Serui', '192.168.188.0/24', '172.16.6.51', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(85, 'RRI Tahuna', '192.168.189.0/24', '172.16.6.87', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(86, 'RRI Wamena', '192.168.190.0/24', '172.16.6.88', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(87, 'RRI Tarakan', '192.168.199.0/24', '172.16.6.7', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(88, 'RRI Gunungsitoli', '192.168.200.0/24', '172.16.6.61', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(89, 'RRI Talaud', '192.168.205.0/24', '172.16.6.96', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(90, 'RRI Nias Selatan', '192.168.240.0/24', '172.16.6.98', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(91, 'RRI Kaimana', '192.168.241.0/24', '172.16.6.99', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(92, 'RRI Jember', '192.168.249.0/24', '172.16.6.42', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(93, 'RRI Nusantara', '192.168.250.0/24', '172.16.6.11', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(94, 'RRI Palu', '192.168.251.0/24', '172.16.6.6', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(95, 'RRI SPI', '192.168.252.0/24', '172.16.5.6', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(96, 'RRI Bandung', '192.168.253.0/24', '172.16.6.4', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(97, 'RRI Medan', '192.168.254.0/24', '172.16.6.15', 'online', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(98, 'RRI Bintuni', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(99, 'RRI Oksibil', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(100, 'RRI Skow', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(101, 'RRI Miangas', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(102, 'Long Bangun', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(103, 'RRI Singkil', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16'),
(104, 'Pusat Pemberitaan', '', '', 'offline', '2026-01-28 10:15:16', '2026-01-28 10:15:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_page_locks`
--
ALTER TABLE `admin_page_locks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_page_unique` (`user_id`,`page`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_status_published` (`status`,`published_at`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_author` (`author_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_user` (`created_at`,`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `audit_logs_ibfk_1` (`user_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `idx_timestamp` (`timestamp`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidents_ibfk_1` (`reporter_id`),
  ADD KEY `incidents_ibfk_2` (`assignee_id`);

--
-- Indexes for table `incident_attachments`
--
ALTER TABLE `incident_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incident_id` (`incident_id`);

--
-- Indexes for table `incident_notes`
--
ALTER TABLE `incident_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incident_id` (`incident_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ip_network` (`network_id`);

--
-- Indexes for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username_time` (`username`,`attempt_time`),
  ADD KEY `idx_ip_time` (`ip_address`,`attempt_time`),
  ADD KEY `idx_attempt_time` (`attempt_time`);

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `server_credentials`
--
ALTER TABLE `server_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_division_active` (`division`,`is_active`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `vpn_allocation`
--
ALTER TABLE `vpn_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vpn_allocations`
--
ALTER TABLE `vpn_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vpn_ips`
--
ALTER TABLE `vpn_ips`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_page_locks`
--
ALTER TABLE `admin_page_locks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_attachments`
--
ALTER TABLE `incident_attachments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_notes`
--
ALTER TABLE `incident_notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `server_credentials`
--
ALTER TABLE `server_credentials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vpn_allocation`
--
ALTER TABLE `vpn_allocation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `vpn_allocations`
--
ALTER TABLE `vpn_allocations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `vpn_ips`
--
ALTER TABLE `vpn_ips`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `incidents_ibfk_2` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `incident_attachments`
--
ALTER TABLE `incident_attachments`
  ADD CONSTRAINT `incident_attachments_ibfk_1` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `incident_notes`
--
ALTER TABLE `incident_notes`
  ADD CONSTRAINT `incident_notes_ibfk_1` FOREIGN KEY (`incident_id`) REFERENCES `incidents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incident_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD CONSTRAINT `fk_ip_network` FOREIGN KEY (`network_id`) REFERENCES `networks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

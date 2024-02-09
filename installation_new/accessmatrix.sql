-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2024 at 04:58 AM
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
-- Database: `accessmatrix`
--

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
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_license`
--

CREATE TABLE `group_license` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `license_id` bigint(20) UNSIGNED NOT NULL,
  `license_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_license_logs`
--

CREATE TABLE `group_license_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `license_id` bigint(20) UNSIGNED NOT NULL,
  `action_type` enum('create','delete') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_project`
--

CREATE TABLE `group_project` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_project_logs`
--

CREATE TABLE `group_project_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `action_type` enum('create','delete') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `license_id` bigint(20) UNSIGNED NOT NULL,
  `license_name` varchar(100) NOT NULL,
  `license_desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `type_action` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `column_name` varchar(255) DEFAULT NULL,
  `record_id` bigint(20) UNSIGNED DEFAULT NULL,
  `record_name` varchar(255) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(68, '2023_12_08_004823_create_group_license_table', 1),
(69, '2023_12_08_004859_create_group_project_table', 1),
(76, '2023_12_14_033243_add_columns_to_group_license_table', 5),
(77, '2023_12_14_033535_add_columns_to_group_project_table', 5),
(78, '2023_12_14_063311_create_group_license_table', 6),
(91, '2023_12_11_064426_add_state_to_projects_table', 7),
(94, '2023_12_13_072027_remove_state_from_projects_table', 7),
(112, '2023_12_19_022027_create_staffs_table', 9),
(139, '2014_10_12_000000_create_users_table', 10),
(140, '2014_10_12_100000_create_password_reset_tokens_table', 10),
(141, '2014_10_12_200000_add_two_factor_columns_to_users_table', 10),
(142, '2018_08_08_100000_create_telescope_entries_table', 10),
(143, '2019_08_19_000000_create_failed_jobs_table', 10),
(144, '2019_12_14_000001_create_personal_access_tokens_table', 10),
(145, '2023_11_26_092343_create_sessions_table', 10),
(146, '2023_11_27_042516_create_licenses_table', 10),
(147, '2023_12_06_073149_create_projects_table', 10),
(148, '2023_12_08_004058_create_groups_table', 10),
(149, '2023_12_13_014450_add_soft_deletes_to_licenses_table', 10),
(150, '2023_12_13_070353_add_deleted_at_to_projects_table', 10),
(151, '2023_12_14_064433_create_group_license_table', 10),
(152, '2023_12_14_065511_create_group_project_table', 10),
(153, '2023_12_18_023817_add_soft_deletes_to_groups_table', 10),
(154, '2023_12_26_062957_create_logs_table', 10),
(155, '2023_12_29_075102_create_group_license_logs_table', 10),
(156, '2023_12_29_075102_create_group_project_logs_table', 10),
(157, '2024_01_02_040022_add_record_name_to_logs_table', 10),
(158, '2024_01_08_045416_create_staffs_table', 10);

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id_rw` varchar(255) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `dept_id` varchar(255) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telescope_entries`
--

INSERT INTO `telescope_entries` (`sequence`, `uuid`, `batch_id`, `family_hash`, `should_display_on_index`, `type`, `content`, `created_at`) VALUES
(1, '9b4ab151-177f-4ea4-9b1b-6db584b9e02f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select table_name as `name`, (data_length + index_length) as `size`, table_comment as `comment`, engine as `engine`, table_collation as `collation` from information_schema.tables where table_schema = \'accessmatrix\' and table_type = \'BASE TABLE\' order by table_name\",\"time\":\"7.54\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"7e07958a392fbd4a662bb3ec1607819c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:27'),
(2, '9b4ab151-1de7-4bf7-806a-c05166499d82', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select `migration` from `migrations` order by `batch` asc, `migration` asc\",\"time\":\"1.19\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"ed08a59c7f0b8851f0fd2291ca94d5c7\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:27'),
(3, '9b4ab151-f2d1-48c4-8547-4a39d082b714', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `staffs`\",\"time\":\"25.78\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_08_045416_create_staffs_table.php\",\"line\":32,\"hash\":\"bbd6a134c476157e100cdefa1cce6f18\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(4, '9b4ab152-001d-4617-9933-9ab5716a7c76', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2024_01_08_045416_create_staffs_table\'\",\"time\":\"3.21\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(5, '9b4ab152-0634-4bad-a17c-2f6dee996e77', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `logs` drop `record_name`\",\"time\":\"13.40\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_02_040022_add_record_name_to_logs_table.php\",\"line\":24,\"hash\":\"1a13da035ed8fea6dc08866ac2e5894a\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(6, '9b4ab152-0a44-4e82-b883-c93be1bab5ac', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2024_01_02_040022_add_record_name_to_logs_table\'\",\"time\":\"3.61\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(7, '9b4ab152-0ede-4dd8-a021-c1d7df14a624', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `group_project_logs`\",\"time\":\"10.08\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_project_logs_table.php\",\"line\":32,\"hash\":\"904927423717b13e939af378c1d689a6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(8, '9b4ab152-117f-4e19-91bc-1b98e8c9a78d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_29_075102_create_group_project_logs_table\'\",\"time\":\"2.97\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(9, '9b4ab152-173a-4b79-bd0a-e7618799206f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `group_license_logs`\",\"time\":\"11.01\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_license_logs_table.php\",\"line\":32,\"hash\":\"0527cf811c3941ff14b1cd22030da75c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(10, '9b4ab152-1ae2-4d29-90de-f689b55aebeb', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_29_075102_create_group_license_logs_table\'\",\"time\":\"2.77\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(11, '9b4ab152-20a9-4381-8695-be220e8dcef1', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `logs`\",\"time\":\"12.98\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_26_062957_create_logs_table.php\",\"line\":34,\"hash\":\"84253d7718018264cab9d08cd9244e71\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(12, '9b4ab152-233e-44fc-845c-4be09f78866e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_26_062957_create_logs_table\'\",\"time\":\"2.16\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(13, '9b4ab152-276b-49c2-9d5e-f1e0c90dba55', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `groups` drop `deleted_at`\",\"time\":\"9.23\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_18_023817_add_soft_deletes_to_groups_table.php\",\"line\":25,\"hash\":\"204f2c71d71067788b5c29bb0e3df0c9\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(14, '9b4ab152-2a3b-42cf-a2c8-6e3aeaedef1e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_18_023817_add_soft_deletes_to_groups_table\'\",\"time\":\"2.51\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(15, '9b4ab152-2f1b-430c-af74-ab9a103544ba', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `group_project`\",\"time\":\"10.88\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_065511_create_group_project_table.php\",\"line\":31,\"hash\":\"9b1a6762cc553616b2cb1dda7b87ec73\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(16, '9b4ab152-31da-427d-8af7-1eb9b87940c7', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_14_065511_create_group_project_table\'\",\"time\":\"2.81\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(17, '9b4ab152-3679-47ba-afd6-2702006f1157', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `group_license`\",\"time\":\"9.79\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_064433_create_group_license_table.php\",\"line\":31,\"hash\":\"59541b16a7a1b32b63b540653aedea20\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(18, '9b4ab152-3958-4d4f-a8ab-6b468c2f809f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_14_064433_create_group_license_table\'\",\"time\":\"2.84\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(19, '9b4ab152-3e87-4f91-b460-01c93bf8166f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `projects` drop `deleted_at`\",\"time\":\"10.45\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_13_070353_add_deleted_at_to_projects_table.php\",\"line\":25,\"hash\":\"fdd4a84836693fa61fd855a6b2acf394\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(20, '9b4ab152-41fa-41fe-a93e-fad39faebfed', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_13_070353_add_deleted_at_to_projects_table\'\",\"time\":\"2.36\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(21, '9b4ab152-4721-4ddc-94fd-40361401187a', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `licenses` drop `deleted_at`\",\"time\":\"11.90\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_13_014450_add_soft_deletes_to_licenses_table.php\",\"line\":25,\"hash\":\"3303a9ec5aa80422b4cb2ddd4ee30a85\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(22, '9b4ab152-4957-42c6-9a60-3886eef1c464', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_13_014450_add_soft_deletes_to_licenses_table\'\",\"time\":\"2.19\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(23, '9b4ab152-4d85-40d2-815f-2fb13a269296', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `groups`\",\"time\":\"9.56\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_08_004058_create_groups_table.php\",\"line\":21,\"hash\":\"68b164fd96cfe1d0a317a7a583d8f2c5\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(24, '9b4ab152-5023-4844-8490-c39c26b25bf0', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_08_004058_create_groups_table\'\",\"time\":\"2.43\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(25, '9b4ab152-54b4-4a8c-b38e-d5da726597af', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `projects`\",\"time\":\"10.20\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_06_073149_create_projects_table.php\",\"line\":27,\"hash\":\"d1b2e29f9359a106c2222096ddd52496\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(26, '9b4ab152-57a3-4726-ab01-43d96a5f68be', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_12_06_073149_create_projects_table\'\",\"time\":\"2.59\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(27, '9b4ab152-5bc5-410b-adb1-ac598021f3cf', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `licenses`\",\"time\":\"9.33\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_27_042516_create_licenses_table.php\",\"line\":27,\"hash\":\"0778ac340cc43d3870b42011c3e9825d\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(28, '9b4ab152-5df9-41c4-8499-45a8e6831b8f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_11_27_042516_create_licenses_table\'\",\"time\":\"2.00\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(29, '9b4ab152-6237-4e19-8700-151347665313', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `sessions`\",\"time\":\"9.43\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_26_092343_create_sessions_table.php\",\"line\":29,\"hash\":\"cd6c841fcf4cccdcc2a6b330b38c4211\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(30, '9b4ab152-64b0-4653-b8ea-ce5f229cee9c', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2023_11_26_092343_create_sessions_table\'\",\"time\":\"1.75\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(31, '9b4ab152-6947-47f5-978e-d9e6fa80701d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `personal_access_tokens`\",\"time\":\"10.53\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_12_14_000001_create_personal_access_tokens_table.php\",\"line\":31,\"hash\":\"dfecf6a194a220d44739af401d9216dc\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(32, '9b4ab152-6bc9-4c7c-b4be-016d5554e6e9', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2019_12_14_000001_create_personal_access_tokens_table\'\",\"time\":\"2.41\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(33, '9b4ab152-6ff4-4635-90ea-2a5ad51ff712', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `failed_jobs`\",\"time\":\"9.17\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_08_19_000000_create_failed_jobs_table.php\",\"line\":30,\"hash\":\"07eda76d9bdd9b08e735c0b2a92a6c88\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(34, '9b4ab152-7268-4c92-86fe-a10ba2b93d36', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2019_08_19_000000_create_failed_jobs_table\'\",\"time\":\"1.83\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(35, '9b4ab152-77a1-40dd-b5d0-fbd7745b72c9', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `telescope_entries_tags`\",\"time\":\"10.86\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"48c7503ca003260b5d7b49b69c32e629\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(36, '9b4ab152-7b27-422a-b6b6-8ffd80c07293', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `telescope_entries`\",\"time\":\"7.99\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"3099636654c39794818dc5406e9671de\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(37, '9b4ab152-7e75-48b0-a0e3-6a94284377d3', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `telescope_monitoring`\",\"time\":\"7.40\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"ff4b292b483cb388d75b5b85e3cd0ce6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(38, '9b4ab152-81bf-4824-845f-e0bf3fbd5faa', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2018_08_08_100000_create_telescope_entries_table\'\",\"time\":\"2.94\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(39, '9b4ab152-8670-4b91-ad87-59e8cc875de6', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `users` drop `two_factor_secret`, drop `two_factor_recovery_codes`, drop `two_factor_confirmed_at`\",\"time\":\"10.35\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_200000_add_two_factor_columns_to_users_table.php\",\"line\":37,\"hash\":\"dd1fb9f1868383574e587e678c1ef988\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(40, '9b4ab152-890f-400f-8ead-f5afd19990fc', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2014_10_12_200000_add_two_factor_columns_to_users_table\'\",\"time\":\"1.68\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(41, '9b4ab152-8be9-40c3-8763-07db7e55dd12', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `password_reset_tokens`\",\"time\":\"6.03\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_100000_create_password_reset_tokens_table.php\",\"line\":26,\"hash\":\"ee596a277650a7039f06e0363f0a4704\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(42, '9b4ab152-8f08-46c3-98c6-1dc1b96fda5c', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2014_10_12_100000_create_password_reset_tokens_table\'\",\"time\":\"2.82\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(43, '9b4ab152-91f8-4f2b-90a2-f5af85f5db0f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"drop table if exists `users`\",\"time\":\"5.96\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_000000_create_users_table.php\",\"line\":32,\"hash\":\"f6ddcf4de1eb548a5650c082714b7223\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(44, '9b4ab152-9488-4e95-8893-a2a6c45b8b68', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"delete from `migrations` where `migration` = \'2014_10_12_000000_create_users_table\'\",\"time\":\"1.85\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"dfbd60cce18ac64c66053ed47bfa86b6\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(45, '9b4ab152-b107-4b5a-8a62-1b1f99e4a994', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select table_name as `name`, (data_length + index_length) as `size`, table_comment as `comment`, engine as `engine`, table_collation as `collation` from information_schema.tables where table_schema = \'accessmatrix\' and table_type = \'BASE TABLE\' order by table_name\",\"time\":\"2.43\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"7e07958a392fbd4a662bb3ec1607819c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(46, '9b4ab152-b1b6-43ee-978a-389044be41cf', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select table_name as `name`, (data_length + index_length) as `size`, table_comment as `comment`, engine as `engine`, table_collation as `collation` from information_schema.tables where table_schema = \'accessmatrix\' and table_type = \'BASE TABLE\' order by table_name\",\"time\":\"1.19\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"7e07958a392fbd4a662bb3ec1607819c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(47, '9b4ab152-b233-425b-90dc-f2452faa457d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select `migration` from `migrations` order by `batch` asc, `migration` asc\",\"time\":\"0.71\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"ed08a59c7f0b8851f0fd2291ca94d5c7\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(48, '9b4ab152-b37e-4b09-8a7c-0506c83e6d98', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select `migration` from `migrations` order by `batch` asc, `migration` asc\",\"time\":\"0.89\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"ed08a59c7f0b8851f0fd2291ca94d5c7\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(49, '9b4ab152-b490-4193-aded-f5579a5e538e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"select max(`batch`) as aggregate from `migrations`\",\"time\":\"0.60\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"06e60d7b3d1a0c2de504de4e6f27735e\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(50, '9b4ab152-d453-4bb8-90c5-6981cb9b295e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `users` (`user_id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `remember_token` varchar(100) null, `current_team_id` bigint unsigned null, `profile_photo_path` varchar(2048) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.58\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_000000_create_users_table.php\",\"line\":14,\"hash\":\"8b72cf556ea5c13f9962525048195278\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(51, '9b4ab152-dc4b-4f4b-8d86-0b581c394f6d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `users` add unique `users_email_unique`(`email`)\",\"time\":\"19.40\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_000000_create_users_table.php\",\"line\":14,\"hash\":\"0648806a3d18c0f5b81e2257de64675e\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(52, '9b4ab152-dee5-4b87-8187-4970b87159bf', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2014_10_12_000000_create_users_table\', 10)\",\"time\":\"2.17\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(53, '9b4ab152-e362-4860-bc58-75eb2d3b9399', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"10.53\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_100000_create_password_reset_tokens_table.php\",\"line\":14,\"hash\":\"71972dcd17d55f0a744c6632d86d04c2\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(54, '9b4ab152-f8b3-42c1-bb1d-00d05e62c3d8', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `password_reset_tokens` add primary key (`email`)\",\"time\":\"53.87\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_100000_create_password_reset_tokens_table.php\",\"line\":14,\"hash\":\"a78a697898144fbd41f9612330c75666\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(55, '9b4ab152-fc1d-4466-86dc-e8ef8aff0040', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2014_10_12_100000_create_password_reset_tokens_table\', 10)\",\"time\":\"2.45\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(56, '9b4ab153-0070-41eb-b9ed-1267829f82dd', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `users` add `two_factor_secret` text null after `password`, add `two_factor_recovery_codes` text null after `two_factor_secret`, add `two_factor_confirmed_at` timestamp null after `two_factor_recovery_codes`\",\"time\":\"9.86\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2014_10_12_200000_add_two_factor_columns_to_users_table.php\",\"line\":15,\"hash\":\"5a5ceab4e0116f44b7e9387eb3993f3f\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(57, '9b4ab153-02b6-4a95-a02e-36ac532ad360', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2014_10_12_200000_add_two_factor_columns_to_users_table\', 10)\",\"time\":\"1.45\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(58, '9b4ab153-07ec-4951-ba5f-6fec905f179c', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `telescope_entries` (`sequence` bigint unsigned not null auto_increment primary key, `uuid` char(36) not null, `batch_id` char(36) not null, `family_hash` varchar(255) null, `should_display_on_index` tinyint(1) not null default \'1\', `type` varchar(20) not null, `content` longtext not null, `created_at` datetime null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"11.25\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"d9429550f8856c1af1c89f24a6440cb5\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(59, '9b4ab153-15ab-4a92-883d-5c3404355610', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries` add unique `telescope_entries_uuid_unique`(`uuid`)\",\"time\":\"34.22\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"9fb859ae1faff74c6b9e0b70dfd8eea9\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(60, '9b4ab153-1a57-4858-8bbe-036d1299086d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries` add index `telescope_entries_batch_id_index`(`batch_id`)\",\"time\":\"11.33\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"2b075509a9242d6e3f622536c5ccca07\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(61, '9b4ab153-1f6a-4ee8-a3e5-e0fc1c94e742', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries` add index `telescope_entries_family_hash_index`(`family_hash`)\",\"time\":\"12.42\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"3d25a2a244bd2028dfa0326d3dbf7f4c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:28'),
(62, '9b4ab153-2331-453f-a7be-e8ebe732a60b', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries` add index `telescope_entries_created_at_index`(`created_at`)\",\"time\":\"9.07\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"7352e7f84460fb7ffc450e7ea4de9dc7\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(63, '9b4ab153-2728-4715-93f2-3332117740f1', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries` add index `telescope_entries_type_should_display_on_index_index`(`type`, `should_display_on_index`)\",\"time\":\"9.50\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"7317a4cad2dfa1a5167548a6acd0b6a5\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(64, '9b4ab153-3504-4df0-a1e6-9dbeac9586bf', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `telescope_entries_tags` (`entry_uuid` char(36) not null, `tag` varchar(255) not null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"11.97\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"5ed47d3cfcd3051674e3cb7b613f0fba\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(65, '9b4ab153-46a8-421e-85af-8567a0d46346', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries_tags` add index `telescope_entries_tags_entry_uuid_tag_index`(`entry_uuid`, `tag`)\",\"time\":\"44.47\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"d77cdf5585b51f60954d40e76786e20f\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(66, '9b4ab153-4ccd-4c27-9086-d18d9be709d8', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries_tags` add index `telescope_entries_tags_tag_index`(`tag`)\",\"time\":\"14.81\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"0bdb35d17e876d6225a7774a2c17647d\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(67, '9b4ab153-790e-4cc7-9b5b-dfb5767db1fc', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `telescope_entries_tags` add constraint `telescope_entries_tags_entry_uuid_foreign` foreign key (`entry_uuid`) references `telescope_entries` (`uuid`) on delete cascade\",\"time\":\"112.37\",\"slow\":true,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"662a818f80a3a9ba2570081fd7a6af2f\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(68, '9b4ab153-7fba-4e8a-b8e8-3de81bb4f175', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `telescope_monitoring` (`tag` varchar(255) not null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"15.94\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"8cddf327ba1b3bd52637b409200a4c1f\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(69, '9b4ab153-83bf-4163-b85c-d189551bc7a0', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2018_08_08_100000_create_telescope_entries_table\', 10)\",\"time\":\"2.47\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(70, '9b4ab153-9cc9-46f0-b43c-fdd98070011c', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.04\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_08_19_000000_create_failed_jobs_table.php\",\"line\":14,\"hash\":\"2036eec2d3e24057db38a9579d6633e3\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(71, '9b4ab153-adee-4c43-adb2-29156d35c21d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`)\",\"time\":\"43.13\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_08_19_000000_create_failed_jobs_table.php\",\"line\":14,\"hash\":\"f851653a45d1f2394473d70db5636fd3\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(72, '9b4ab153-b1af-4506-a117-3155f7606a8e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2019_08_19_000000_create_failed_jobs_table\', 10)\",\"time\":\"2.47\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(73, '9b4ab153-b815-439e-94df-f87367f15bff', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` varchar(255) not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.22\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_12_14_000001_create_personal_access_tokens_table.php\",\"line\":14,\"hash\":\"c3ce2064f6541373814860c9a7e44c89\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(74, '9b4ab153-c945-429c-a9d0-53fb3722e253', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)\",\"time\":\"43.15\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_12_14_000001_create_personal_access_tokens_table.php\",\"line\":14,\"hash\":\"23e16d13faedc7fd756b258a984d3cad\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(75, '9b4ab153-cfba-407d-a18e-f93cd44a3642', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`)\",\"time\":\"15.77\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2019_12_14_000001_create_personal_access_tokens_table.php\",\"line\":14,\"hash\":\"6d0025967d6eebfcb6fddf6dcb6ed14c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(76, '9b4ab153-d2f9-4970-bc3c-c92ccd0706ec', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2019_12_14_000001_create_personal_access_tokens_table\', 10)\",\"time\":\"2.56\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(77, '9b4ab153-da3a-4d36-9d33-4d4f8cbdd9ad', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `sessions` (`id` varchar(255) not null, `user_id` bigint unsigned null, `ip_address` varchar(45) null, `user_agent` text null, `payload` longtext not null, `last_activity` int not null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"16.83\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_26_092343_create_sessions_table.php\",\"line\":14,\"hash\":\"e457287c9216dbb64c091cade3574faa\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(78, '9b4ab153-edb4-436f-b286-6bc05ec66940', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `sessions` add primary key (`id`)\",\"time\":\"48.95\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_26_092343_create_sessions_table.php\",\"line\":14,\"hash\":\"f028c335170a0a4107ff256777f2b5ef\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(79, '9b4ab153-f695-4ec9-90a0-f875207cdc6e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `sessions` add index `sessions_user_id_index`(`user_id`)\",\"time\":\"21.65\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_26_092343_create_sessions_table.php\",\"line\":14,\"hash\":\"143e0209095c4f5cecfdd51a11268572\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(80, '9b4ab153-fd69-4bbe-9898-bd4452683075', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `sessions` add index `sessions_last_activity_index`(`last_activity`)\",\"time\":\"16.62\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_26_092343_create_sessions_table.php\",\"line\":14,\"hash\":\"5102944fa5d480fdd2bbfbfe1a0c03bc\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(81, '9b4ab154-01e1-4dc0-8a6c-6ef918d42d07', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_11_26_092343_create_sessions_table\', 10)\",\"time\":\"3.33\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(82, '9b4ab154-08b5-454d-8fc7-15dc87760278', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `licenses` (`license_id` bigint unsigned not null auto_increment primary key, `license_name` varchar(100) not null, `license_desc` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"15.41\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_27_042516_create_licenses_table.php\",\"line\":14,\"hash\":\"6f03b7f58c6482fb219ed0da99b31acf\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(83, '9b4ab154-1a2c-4806-9ef4-1253a2f7113b', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `licenses` add unique `licenses_license_name_unique`(`license_name`)\",\"time\":\"43.16\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_11_27_042516_create_licenses_table.php\",\"line\":14,\"hash\":\"8040b8c2348c5b6c69d101ac2548f0ef\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(84, '9b4ab154-1d8e-47ae-951e-40d3eb90dbdb', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_11_27_042516_create_licenses_table\', 10)\",\"time\":\"2.45\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(85, '9b4ab154-23c3-46e2-baaf-d842edfd265a', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `projects` (`project_id` bigint unsigned not null auto_increment primary key, `project_name` varchar(100) not null, `project_desc` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.53\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_06_073149_create_projects_table.php\",\"line\":14,\"hash\":\"e2cd659c7b58762b78fb595aa1e263bc\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(86, '9b4ab154-4016-4cfd-a076-eba5a60c88cf', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `projects` add unique `projects_project_name_unique`(`project_name`)\",\"time\":\"71.69\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_06_073149_create_projects_table.php\",\"line\":14,\"hash\":\"c4fb59a6496edc74dd328bc713d42f50\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(87, '9b4ab154-42fd-45a2-a671-25b67b630340', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_06_073149_create_projects_table\', 10)\",\"time\":\"2.16\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(88, '9b4ab154-49d8-4680-abcd-c6d84425876e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `groups` (`group_id` bigint unsigned not null auto_increment primary key, `group_name` varchar(100) not null, `group_desc` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"15.43\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_08_004058_create_groups_table.php\",\"line\":11,\"hash\":\"574fd64ca2f481ed002088a12c8ac0ba\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(89, '9b4ab154-65d5-4fdf-aa9a-b5af45eb06cb', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `groups` add unique `groups_group_name_unique`(`group_name`)\",\"time\":\"70.51\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_08_004058_create_groups_table.php\",\"line\":11,\"hash\":\"f3a71889c08266f5468d6b0a2d6375f8\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(90, '9b4ab154-6a4c-45bf-b5cd-3cc393bc6954', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_08_004058_create_groups_table\', 10)\",\"time\":\"3.64\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(91, '9b4ab154-6f8a-4b49-be9f-08e1c4b83aba', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `licenses` add `deleted_at` timestamp null\",\"time\":\"11.72\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_13_014450_add_soft_deletes_to_licenses_table.php\",\"line\":14,\"hash\":\"ac30812a52af1a19c4f5b2147e6187cf\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(92, '9b4ab154-7376-4e6d-acbe-7e9c6fd0b395', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_13_014450_add_soft_deletes_to_licenses_table\', 10)\",\"time\":\"2.86\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(93, '9b4ab154-7808-4c00-b911-71d971c3d114', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `projects` add `deleted_at` timestamp null\",\"time\":\"9.09\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_13_070353_add_deleted_at_to_projects_table.php\",\"line\":14,\"hash\":\"ad6a183cbe358398fb7c9274f2207075\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(94, '9b4ab154-7d69-448c-881c-bf4d9e7fd56d', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_13_070353_add_deleted_at_to_projects_table\', 10)\",\"time\":\"3.46\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(95, '9b4ab154-864c-4005-b8e0-5bb35eda236e', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `group_license` (`id` bigint unsigned not null auto_increment primary key, `group_id` bigint unsigned not null, `license_id` bigint unsigned not null, `license_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"20.34\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_064433_create_group_license_table.php\",\"line\":14,\"hash\":\"687bfe852c1e4e7569d17ae5bf09c83a\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:29'),
(96, '9b4ab154-a9ae-4d1e-b8bb-15b1c7a69658', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_license` add constraint `group_license_group_id_foreign` foreign key (`group_id`) references `groups` (`group_id`)\",\"time\":\"89.67\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_064433_create_group_license_table.php\",\"line\":14,\"hash\":\"05fa549e3041f01bdb638a2100a67f52\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30');
INSERT INTO `telescope_entries` (`sequence`, `uuid`, `batch_id`, `family_hash`, `should_display_on_index`, `type`, `content`, `created_at`) VALUES
(97, '9b4ab154-cc3c-4142-8334-504a2c27287f', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_license` add constraint `group_license_license_id_foreign` foreign key (`license_id`) references `licenses` (`license_id`)\",\"time\":\"87.38\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_064433_create_group_license_table.php\",\"line\":14,\"hash\":\"c468f978dc3616c260c9fdc7e4211aab\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(98, '9b4ab154-cf5f-498a-be1a-2c8fcd6e5bfb', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_14_064433_create_group_license_table\', 10)\",\"time\":\"2.21\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(99, '9b4ab154-d467-4ecf-aecf-d81e5bb8c0b0', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `group_project` (`id` bigint unsigned not null auto_increment primary key, `group_id` bigint unsigned not null, `project_id` bigint unsigned not null, `project_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"11.19\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_065511_create_group_project_table.php\",\"line\":14,\"hash\":\"73f4a841681517c929e11f963eeb9ecb\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(100, '9b4ab154-f393-4728-b682-d29b4d224ee0', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_project` add constraint `group_project_group_id_foreign` foreign key (`group_id`) references `groups` (`group_id`)\",\"time\":\"79.10\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_065511_create_group_project_table.php\",\"line\":14,\"hash\":\"3a66d4e512531ffedf6631545c92cf57\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(101, '9b4ab155-18ef-4866-be7b-ff4747f838ed', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_project` add constraint `group_project_project_id_foreign` foreign key (`project_id`) references `projects` (`project_id`)\",\"time\":\"94.82\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_14_065511_create_group_project_table.php\",\"line\":14,\"hash\":\"fd21c9ae97885c8153bd681bf1f9c07c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(102, '9b4ab155-1ca9-4f16-9b46-ff8457bc8c84', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_14_065511_create_group_project_table\', 10)\",\"time\":\"2.14\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(103, '9b4ab155-20e9-4116-9e8a-204c8e7b13ef', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `groups` add `deleted_at` timestamp null\",\"time\":\"9.19\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_18_023817_add_soft_deletes_to_groups_table.php\",\"line\":14,\"hash\":\"d7199a17aee1045e6a18d4d07e0709bf\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(104, '9b4ab155-2505-4667-98e2-f47bca02795a', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_18_023817_add_soft_deletes_to_groups_table\', 10)\",\"time\":\"2.83\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(105, '9b4ab155-2b85-48fe-a560-2ca9e69fa469', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `logs` (`log_id` bigint unsigned not null auto_increment primary key, `type_action` varchar(255) not null, `user_id` bigint unsigned not null, `table_name` varchar(255) not null, `column_name` varchar(255) null, `record_id` bigint unsigned null, `old_value` text null, `new_value` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.56\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_26_062957_create_logs_table.php\",\"line\":14,\"hash\":\"b8a153eb763ff0a86eed24e08495b4e0\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(106, '9b4ab155-53e2-4fcf-ba0e-c4020219b619', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `logs` add constraint `logs_user_id_foreign` foreign key (`user_id`) references `users` (`user_id`)\",\"time\":\"102.36\",\"slow\":true,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_26_062957_create_logs_table.php\",\"line\":14,\"hash\":\"312f5f66a922a145fc3a6d78763f89f8\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(107, '9b4ab155-5801-4278-8279-c8f8eca6d2ba', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_26_062957_create_logs_table\', 10)\",\"time\":\"2.73\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(108, '9b4ab155-6031-4066-87fc-d591f6d78b64', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `group_license_logs` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `group_id` bigint unsigned not null, `license_id` bigint unsigned not null, `action_type` enum(\'create\', \'delete\') not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"18.77\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_license_logs_table.php\",\"line\":14,\"hash\":\"0a2a31304479969604125baf17503ef8\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(109, '9b4ab155-8034-418d-96ed-ab0844cf25bc', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_license_logs` add constraint `group_license_logs_user_id_foreign` foreign key (`user_id`) references `users` (`user_id`)\",\"time\":\"80.97\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_license_logs_table.php\",\"line\":14,\"hash\":\"3c29a9ce28958c9057c7bab540908029\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(110, '9b4ab155-a48d-4a8f-9389-02d9015aeeb4', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_license_logs` add constraint `group_license_logs_group_id_foreign` foreign key (`group_id`) references `groups` (`group_id`)\",\"time\":\"92.10\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_license_logs_table.php\",\"line\":14,\"hash\":\"2a9cb9233802cb788dda9238a97986ac\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(111, '9b4ab155-c895-4390-a037-6531158297de', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_license_logs` add constraint `group_license_logs_license_id_foreign` foreign key (`license_id`) references `licenses` (`license_id`)\",\"time\":\"91.31\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_license_logs_table.php\",\"line\":14,\"hash\":\"6dde3dfee5dab072f0a7965fbdb70d29\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(112, '9b4ab155-cccf-4a40-b16e-fec4965abbba', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_29_075102_create_group_license_logs_table\', 10)\",\"time\":\"2.35\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(113, '9b4ab155-d329-4f95-a4be-812718d0a684', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `group_project_logs` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `group_id` bigint unsigned not null, `project_id` bigint unsigned not null, `action_type` enum(\'create\', \'delete\') not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.23\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_project_logs_table.php\",\"line\":14,\"hash\":\"9a0804d4796855637b8801aad4749544\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(114, '9b4ab156-0dc4-4b33-a4bf-d0450c077d10', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_project_logs` add constraint `group_project_logs_user_id_foreign` foreign key (`user_id`) references `users` (`user_id`)\",\"time\":\"149.22\",\"slow\":true,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_project_logs_table.php\",\"line\":14,\"hash\":\"2e082c3165bb46c23c6e07b9212b5e1c\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:30'),
(115, '9b4ab156-3244-4e22-a360-ed44d5c60866', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_project_logs` add constraint `group_project_logs_group_id_foreign` foreign key (`group_id`) references `groups` (`group_id`)\",\"time\":\"92.61\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_project_logs_table.php\",\"line\":14,\"hash\":\"052c7ea576e61e5ccbfec4c622d4f5e7\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(116, '9b4ab156-56f7-427b-857d-129cc0b16116', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `group_project_logs` add constraint `group_project_logs_project_id_foreign` foreign key (`project_id`) references `projects` (`project_id`)\",\"time\":\"92.94\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2023_12_29_075102_create_group_project_logs_table.php\",\"line\":14,\"hash\":\"3e41558cd837e0f247421973d1129617\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(117, '9b4ab156-5b72-4108-bdfd-3380d9ecb865', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2023_12_29_075102_create_group_project_logs_table\', 10)\",\"time\":\"3.65\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(118, '9b4ab156-611d-49d3-a06b-89b2c9acc101', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `logs` add `record_name` varchar(255) null after `record_id`\",\"time\":\"12.95\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_02_040022_add_record_name_to_logs_table.php\",\"line\":14,\"hash\":\"63c2c3ccd825cc0ab85e25cff12d99b4\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(119, '9b4ab156-6451-4948-93f3-45a7bc31203a', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2024_01_02_040022_add_record_name_to_logs_table\', 10)\",\"time\":\"1.74\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(120, '9b4ab156-6ab9-427b-8266-886c642ec2a6', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"create table `staffs` (`staff_id` bigint unsigned not null auto_increment primary key, `group_id` bigint unsigned null, `staff_id_rw` varchar(255) not null, `staff_name` varchar(255) not null, `dept_id` varchar(255) not null, `dept_name` varchar(255) not null, `status` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'\",\"time\":\"14.94\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_08_045416_create_staffs_table.php\",\"line\":14,\"hash\":\"9abea39d5073865cdd04a7772b0da7de\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(121, '9b4ab156-8b51-468e-b593-74b0ba772fa6', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `staffs` add constraint `staffs_group_id_foreign` foreign key (`group_id`) references `groups` (`group_id`)\",\"time\":\"82.22\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_08_045416_create_staffs_table.php\",\"line\":14,\"hash\":\"93d3097c98ae52430726850cd8965e10\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(122, '9b4ab156-925f-468c-abf1-46016fe623f8', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"alter table `staffs` add unique `staffs_staff_id_rw_unique`(`staff_id_rw`)\",\"time\":\"17.05\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\database\\\\migrations\\\\2024_01_08_045416_create_staffs_table.php\",\"line\":14,\"hash\":\"122b25eec8170c6e393942488382fa5b\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(123, '9b4ab156-9634-4db7-83e2-7d0fd4229b10', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'query', '{\"connection\":\"mysql\",\"bindings\":[],\"sql\":\"insert into `migrations` (`migration`, `batch`) values (\'2024_01_08_045416_create_staffs_table\', 10)\",\"time\":\"2.44\",\"slow\":false,\"file\":\"C:\\\\xampp\\\\htdocs\\\\accessmatrix\\\\artisan\",\"line\":35,\"hash\":\"f2b8e8e4266db16aec6db940c643eb68\",\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31'),
(124, '9b4ab156-bd9e-408c-b61e-eefdcfe8a3da', '9b4ab156-bf52-41dd-9188-23a8b735ccea', NULL, 1, 'command', '{\"command\":\"migrate:refresh\",\"exit_code\":0,\"arguments\":{\"command\":\"migrate:refresh\"},\"options\":{\"database\":null,\"force\":false,\"path\":[],\"realpath\":false,\"seed\":false,\"seeder\":null,\"step\":null,\"help\":false,\"quiet\":false,\"verbose\":false,\"version\":false,\"ansi\":null,\"no-interaction\":false,\"env\":null},\"hostname\":\"LAPTOP-17A4I8IK\"}', '2024-02-09 11:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telescope_entries_tags`
--

INSERT INTO `telescope_entries_tags` (`entry_uuid`, `tag`) VALUES
('9b4ab153-790e-4cc7-9b5b-dfb5767db1fc', 'slow'),
('9b4ab155-53e2-4fcf-ba0e-c4020219b619', 'slow'),
('9b4ab156-0dc4-4b33-a4bf-d0450c077d10', 'slow');

-- --------------------------------------------------------

--
-- Table structure for table `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `groups_group_name_unique` (`group_name`);

--
-- Indexes for table `group_license`
--
ALTER TABLE `group_license`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_license_group_id_foreign` (`group_id`),
  ADD KEY `group_license_license_id_foreign` (`license_id`);

--
-- Indexes for table `group_license_logs`
--
ALTER TABLE `group_license_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_license_logs_user_id_foreign` (`user_id`),
  ADD KEY `group_license_logs_group_id_foreign` (`group_id`),
  ADD KEY `group_license_logs_license_id_foreign` (`license_id`);

--
-- Indexes for table `group_project`
--
ALTER TABLE `group_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_project_group_id_foreign` (`group_id`),
  ADD KEY `group_project_project_id_foreign` (`project_id`);

--
-- Indexes for table `group_project_logs`
--
ALTER TABLE `group_project_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_project_logs_user_id_foreign` (`user_id`),
  ADD KEY `group_project_logs_group_id_foreign` (`group_id`),
  ADD KEY `group_project_logs_project_id_foreign` (`project_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`license_id`),
  ADD UNIQUE KEY `licenses_license_name_unique` (`license_name`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD UNIQUE KEY `projects_project_name_unique` (`project_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staffs_staff_id_rw_unique` (`staff_id_rw`),
  ADD KEY `staffs_group_id_foreign` (`group_id`);

--
-- Indexes for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indexes for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_license`
--
ALTER TABLE `group_license`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_license_logs`
--
ALTER TABLE `group_license_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_project`
--
ALTER TABLE `group_project`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_project_logs`
--
ALTER TABLE `group_project_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `license_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_license`
--
ALTER TABLE `group_license`
  ADD CONSTRAINT `group_license_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `group_license_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`license_id`);

--
-- Constraints for table `group_license_logs`
--
ALTER TABLE `group_license_logs`
  ADD CONSTRAINT `group_license_logs_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `group_license_logs_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`license_id`),
  ADD CONSTRAINT `group_license_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `group_project`
--
ALTER TABLE `group_project`
  ADD CONSTRAINT `group_project_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `group_project_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `group_project_logs`
--
ALTER TABLE `group_project_logs`
  ADD CONSTRAINT `group_project_logs_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`),
  ADD CONSTRAINT `group_project_logs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `group_project_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`);

--
-- Constraints for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

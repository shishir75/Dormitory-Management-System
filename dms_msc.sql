-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2021 at 10:08 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms_msc`
--

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `user_id`, `hall_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 40.00, '2021-09-14 20:17:00', '2021-09-15 10:58:31'),
(2, 3, 1, 20.00, '2021-09-14 20:17:00', '2021-09-14 21:25:07'),
(3, 4, 1, 20.00, '2021-09-14 20:43:30', '2021-09-15 10:58:31'),
(4, 1, 0, 0.00, '2021-09-14 21:02:22', '2021-09-14 21:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dining_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_date` date NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` int(11) NOT NULL DEFAULT '20',
  `max_count` int(11) NOT NULL DEFAULT '1000',
  `sold_coupon` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `dining_id`, `coupon_date`, `type`, `unit_price`, `max_count`, `sold_coupon`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-09-16', 'L', 20, 100, 1, '2021-09-14 20:03:59', '2021-09-14 20:43:29'),
(2, 1, '2021-09-16', 'D', 20, 100, 0, '2021-09-14 20:04:16', '2021-09-15 10:58:31'),
(3, 1, '2021-09-17', 'L', 20, 100, 0, '2021-09-14 20:05:26', '2021-09-14 20:05:26'),
(4, 1, '2021-09-17', 'D', 20, 100, 0, '2021-09-14 20:05:38', '2021-09-14 20:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_details`
--

CREATE TABLE `coupon_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_valid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unused',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_details`
--

INSERT INTO `coupon_details` (`id`, `coupon_id`, `student_id`, `coupon_no`, `is_valid`, `created_at`, `updated_at`) VALUES
(1, 1, 353, '20210916-1-353-L', 'used', '2021-09-14 20:43:29', '2021-09-15 18:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `depts`
--

CREATE TABLE `depts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depts`
--

INSERT INTO `depts` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'Institute of Information Technology', 'IIT', NULL, NULL),
(2, 'Department of Mathamatics', 'MATH', NULL, NULL),
(3, 'Duncan', 'Duncan', NULL, NULL),
(4, 'Jeramie', 'Jeramie', NULL, NULL),
(5, 'Edmond', 'Edmond', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dinings`
--

CREATE TABLE `dinings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dinings`
--

INSERT INTO `dinings` (`id`, `hall_id`, `name`, `email`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rabindranath Tagore Hall Dining', 'rth_dining@gmail.com', 'RTH Dining', NULL, NULL),
(2, 2, 'Sheikh Hasina Hall Dining', 'shh_dining@gmail.com', 'SHH Dining', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `for_male_female` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'M',
  `total_seat` int(11) NOT NULL,
  `available_seat` int(11) DEFAULT NULL,
  `pending_bill` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `name`, `short_name`, `for_male_female`, `total_seat`, `available_seat`, `pending_bill`, `created_at`, `updated_at`) VALUES
(1, 'Rabindranath Tagore Hall', 'RTH', 'M', 1000, 66, 0, NULL, '2021-09-14 21:25:06'),
(2, 'Sheikh Hasina Hall', 'SHH', 'F', 1000, 64, 0, NULL, '2021-09-14 20:07:29'),
(3, 'Krystina Mertz', 'krystina-mertz', 'M', 1000, 120, 0, NULL, NULL),
(4, 'Loren Farrell V', 'loren-farrell-v', 'M', 1000, 110, 0, NULL, NULL),
(5, 'Kelsi Stamm', 'kelsi-stamm', 'F', 1000, 60, 0, NULL, NULL),
(6, 'Felipe Kuhic', 'felipe-kuhic', 'F', 1000, 90, 0, NULL, NULL),
(7, 'Ethel Buckridge', 'ethel-buckridge', 'M', 1000, 50, 0, NULL, NULL),
(8, 'Miss Marilyne Nolan', 'miss-marilyne-nolan', 'M', 1000, 120, 0, NULL, NULL),
(9, 'Stephan Bergnaum', 'stephan-bergnaum', 'M', 1000, 100, 0, NULL, NULL),
(10, 'Oceane Herzog', 'oceane-herzog', 'M', 1000, 80, 0, NULL, NULL),
(11, 'Mervin McClure', 'mervin-mcclure', 'F', 1000, 60, 0, NULL, NULL),
(12, 'Denis Herzog', 'denis-herzog', 'F', 1000, 90, 0, NULL, NULL),
(13, 'Vilma Collins DDS', 'vilma-collins-dds', 'M', 1000, 120, 0, NULL, NULL),
(14, 'Prof. Chelsie Renner', 'prof-chelsie-renner', 'F', 1000, 120, 0, NULL, NULL),
(15, 'Dr. Ayden Bartoletti', 'dr-ayden-bartoletti', 'M', 1000, 100, 0, NULL, NULL),
(16, 'Tara Bernier', 'tara-bernier', 'F', 1000, 100, 0, NULL, NULL),
(17, 'Kayden Ondricka', 'kayden-ondricka', 'F', 1000, 70, 0, NULL, NULL),
(18, 'Samanta Schaefer', 'samanta-schaefer', 'F', 1000, 100, 0, NULL, NULL),
(19, 'Prof. Russel Willms', 'prof-russel-willms', 'M', 1000, 70, 0, NULL, NULL),
(20, 'Mrs. Margie Hettinger', 'mrs-margie-hettinger', 'F', 1000, 60, 0, NULL, NULL),
(21, 'Dr. Gilbert Dooley', 'dr-gilbert-dooley', 'M', 1000, 90, 0, NULL, NULL),
(22, 'Sydnie Stroman', 'sydnie-stroman', 'M', 1000, 60, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hall_bills`
--

CREATE TABLE `hall_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `start_month` datetime NOT NULL,
  `end_month` datetime NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hall_bills`
--

INSERT INTO `hall_bills` (`id`, `student_id`, `hall_id`, `start_month`, `end_month`, `amount`, `created_at`, `updated_at`) VALUES
(1, 353, 1, '2021-09-01 12:00:00', '2021-10-01 12:01:00', 40.00, '2021-09-14 21:02:21', '2021-09-14 21:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `hall_rooms`
--

CREATE TABLE `hall_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL,
  `room_no` int(11) NOT NULL,
  `seat_count` int(11) NOT NULL DEFAULT '4',
  `available_seat` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hall_rooms`
--

INSERT INTO `hall_rooms` (`id`, `hall_id`, `room_no`, `seat_count`, `available_seat`, `created_at`, `updated_at`) VALUES
(1, 1, 101, 4, 3, '2021-09-14 20:11:29', '2021-09-14 20:12:06'),
(2, 1, 102, 4, 4, '2021-09-14 20:11:29', '2021-09-15 17:00:48'),
(3, 1, 103, 4, 4, '2021-09-14 20:11:29', '2021-09-14 20:11:29'),
(4, 1, 104, 4, 4, '2021-09-14 20:11:29', '2021-09-14 20:11:29'),
(5, 1, 105, 4, 4, '2021-09-14 20:11:29', '2021-09-14 20:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_07_22_161008_create_roles_table', 1),
(4, '2019_07_26_193103_create_depts_table', 1),
(5, '2019_07_26_203559_create_halls_table', 1),
(6, '2019_07_26_205037_create_sessions_table', 1),
(7, '2019_07_31_021329_create_students_table', 1),
(8, '2021_09_07_114753_create_hall_rooms_table', 1),
(9, '2021_09_08_171134_create_balances_table', 1),
(10, '2021_09_08_171210_create_transactions_table', 1),
(11, '2021_09_08_233929_create_dinings_table', 1),
(12, '2021_09_09_005939_create_coupons_table', 1),
(13, '2021_09_09_150226_create_coupon_details_table', 1),
(14, '2021_09_12_153953_create_hall_bills_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Register', 'register', NULL, NULL),
(2, 'Dept Office', 'dept-office', NULL, NULL),
(3, 'Hall Office', 'hall-office', NULL, NULL),
(4, 'Student', 'student', NULL, NULL),
(5, 'Dining', 'dining', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '2014-15', NULL, NULL),
(2, '2015-16', NULL, NULL),
(3, '2016-17', NULL, NULL),
(4, '2017-18', NULL, NULL),
(5, '2018-19', NULL, NULL),
(6, '2019-20', NULL, NULL),
(7, '2020-21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` bigint(20) UNSIGNED NOT NULL,
  `reg_no` bigint(20) NOT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `room_no` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `sex` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'M',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `session_id`, `dept_id`, `reg_no`, `hall_id`, `room_no`, `status`, `sex`, `created_at`, `updated_at`) VALUES
(1, 'Pascale Dach', 'gottlieb.sadye@example.org', 5, 2, 45015, 10, NULL, 1, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(2, 'Miss Dandre Hane', 'waters.clair@example.org', 4, 1, 45597, 9, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(3, 'Marjory Cassin', 'stroman.elinor@example.net', 4, 3, 40301, 3, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(4, 'Marcelina Hand', 'jwisozk@example.net', 7, 5, 43898, 14, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(5, 'Katrine Weissnat', 'qgoyette@example.net', 2, 5, 46090, 22, NULL, 1, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(6, 'Prof. Anais Streich', 'carli93@example.org', 5, 1, 43643, 3, NULL, 1, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(7, 'Keshawn Ruecker DDS', 'roselyn85@example.net', 1, 2, 47042, 21, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(8, 'Ada Sipes DVM', 'mcglynn.elvie@example.org', 1, 1, 49817, 11, NULL, 2, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(9, 'Nova Jakubowski V', 'bklein@example.org', 4, 3, 42924, 22, NULL, 1, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(10, 'Gaston Larkin Jr.', 'sibyl51@example.com', 3, 3, 46893, 9, NULL, 1, 'F', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(11, 'Jackie Cassin', 'franecki.evert@example.com', 3, 5, 44748, 2, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(12, 'Abbie Towne', 'watson.gottlieb@example.org', 6, 4, 45323, 7, NULL, 1, 'M', '2021-09-14 19:55:33', '2021-09-14 19:55:33'),
(13, 'Ms. Candice Marquardt', 'steuber.jordy@example.net', 3, 4, 41755, 19, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(14, 'Kristy Olson PhD', 'alfonzo.beahan@example.com', 4, 2, 47453, 19, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(15, 'Rashawn Frami', 'barry45@example.org', 3, 5, 47668, 16, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(16, 'Lois Yost', 'ola45@example.com', 5, 2, 48989, 19, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(17, 'Carole Volkman', 'tbayer@example.com', 6, 1, 47487, 18, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(18, 'Amira Walsh', 'vivianne.oreilly@example.com', 4, 1, 40578, 4, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(19, 'Leonor Okuneva', 'winnifred.raynor@example.net', 1, 4, 41824, 11, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(20, 'Abdiel Torp', 'dayna19@example.com', 4, 2, 40005, 7, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(21, 'Demetrius Hansen', 'vjenkins@example.com', 1, 4, 40462, 21, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(22, 'Julie Bailey', 'patricia.prosacco@example.net', 6, 4, 46130, 11, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(23, 'Abbey Mueller', 'craig.moen@example.org', 3, 4, 40684, 3, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(24, 'Prof. Nigel Yost PhD', 'gerlach.rico@example.org', 4, 2, 49295, 5, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(25, 'Miss Kristy Ortiz', 'howell12@example.org', 6, 5, 46167, 6, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(26, 'Vernie Lebsack', 'florencio.mante@example.net', 3, 3, 43430, 2, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(27, 'Elwyn Feeney', 'howell.jordi@example.net', 6, 5, 45584, 6, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(28, 'Katlyn Doyle', 'maye45@example.org', 7, 1, 44712, 14, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(29, 'Alyce Bogan', 'armstrong.drake@example.org', 2, 4, 43334, 22, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(30, 'Esteban Kreiger Sr.', 'elvie28@example.com', 5, 5, 43932, 15, NULL, 1, 'M', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(31, 'Lupe Schoen III', 'mia61@example.com', 3, 4, 43845, 8, NULL, 1, 'F', '2021-09-14 19:55:34', '2021-09-14 19:55:34'),
(32, 'Marcelino Mayert', 'purdy.danielle@example.com', 2, 4, 43262, 12, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(33, 'Donna Macejkovic III', 'rkeebler@example.org', 4, 2, 42149, 5, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(34, 'Natalie Klocko', 'ggoodwin@example.com', 3, 5, 40570, 9, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(35, 'Kamren Dooley', 'elinore61@example.com', 7, 2, 45370, 10, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(36, 'Nick Cremin', 'sipes.katrina@example.org', 4, 1, 44258, 8, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(37, 'Prof. Jaylin Streich', 'sheridan38@example.com', 4, 4, 49347, 1, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(38, 'Kellie Kemmer Sr.', 'missouri.yundt@example.com', 1, 1, 44064, 22, NULL, 2, 'M', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(39, 'Mrs. Stephany Hintz', 'gwiza@example.org', 2, 3, 44360, 2, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(40, 'Mr. Jarrett Wuckert II', 'vroberts@example.org', 1, 2, 40923, 8, NULL, 1, 'M', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(41, 'Arely Kemmer II', 'kub.gus@example.com', 5, 4, 40768, 13, NULL, 1, 'M', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(42, 'Colby Sipes', 'carolanne69@example.org', 5, 3, 40942, 13, NULL, 1, 'F', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(43, 'Malinda Reichel', 'arnoldo.lockman@example.net', 2, 3, 42832, 16, NULL, 1, 'M', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(44, 'Lela Schuster', 'omari.green@example.com', 7, 1, 45885, 7, NULL, 1, 'M', '2021-09-14 19:55:35', '2021-09-14 19:55:35'),
(45, 'Bella Price', 'tlockman@example.net', 6, 5, 43124, 14, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(46, 'Urban Ankunding', 'farrell.kassandra@example.com', 4, 5, 48204, 2, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(47, 'Yadira Haag', 'bartoletti.kara@example.net', 1, 1, 44095, 8, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(48, 'Chet Lowe', 'swintheiser@example.org', 4, 4, 44101, 15, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(49, 'Broderick Waelchi', 'colt.abbott@example.com', 3, 1, 44825, 5, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(50, 'Darron Wolf', 'carlotta.johnston@example.org', 6, 1, 43204, 14, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(51, 'Dr. Horacio Considine', 'brown.reuben@example.net', 7, 2, 49607, 11, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(52, 'Ozella Thompson DVM', 'nasir.crooks@example.com', 3, 1, 42536, 17, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(53, 'Paige Stamm MD', 'arnulfo.mertz@example.com', 6, 5, 48168, 18, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(54, 'Mr. Jaylon Luettgen II', 'aaron38@example.org', 6, 1, 46011, 1, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(55, 'Landen Walter', 'maribel36@example.com', 6, 2, 44645, 22, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(56, 'Prof. Duncan Kreiger Jr.', 'camden.zieme@example.org', 7, 3, 47793, 19, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(57, 'Dr. Jacquelyn Heller DVM', 'mtorp@example.net', 5, 5, 43519, 6, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(58, 'Ms. Amiya Parker IV', 'xlubowitz@example.org', 5, 1, 46603, 2, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(59, 'Ms. Therese Boehm', 'gstokes@example.com', 1, 5, 41433, 15, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(60, 'Miss Izabella Boyle DVM', 'cristal35@example.com', 3, 1, 45917, 20, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(61, 'Prof. Leif Pollich', 'renner.pete@example.com', 5, 1, 47447, 2, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(62, 'Mr. Waino Marquardt PhD', 'herman.bryana@example.com', 5, 2, 45928, 13, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(63, 'Loraine Wisozk', 'rjohnson@example.net', 1, 5, 47310, 8, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(64, 'Clare Kuhlman', 'isaac32@example.net', 1, 1, 45200, 18, NULL, 2, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(65, 'Korey Kovacek', 'hcarter@example.com', 6, 2, 43996, 11, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(66, 'Mr. Derrick Little V', 'krystina.hudson@example.org', 5, 1, 40324, 15, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(67, 'Kirstin Kertzmann III', 'hassan71@example.org', 1, 5, 47117, 6, NULL, 1, 'F', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(68, 'Nathaniel Ortiz Sr.', 'eliseo.ankunding@example.com', 6, 5, 40629, 16, NULL, 1, 'M', '2021-09-14 19:55:36', '2021-09-14 19:55:36'),
(69, 'Izaiah Terry', 'karlee.olson@example.net', 7, 2, 48860, 22, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(70, 'Miss Rhea Wolff', 'izabella66@example.org', 2, 1, 42055, 8, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(71, 'Caitlyn Hartmann PhD', 'loyce.schneider@example.org', 4, 2, 49168, 11, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(72, 'Ms. Camila Braun', 'andres27@example.net', 1, 4, 48995, 8, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(73, 'Justine Stark', 'white.earnest@example.org', 4, 5, 44809, 19, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(74, 'Novella Ryan', 'christop.klocko@example.net', 2, 2, 40526, 21, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(75, 'Esperanza Ritchie', 'dean78@example.net', 1, 4, 43980, 15, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(76, 'Aglae Pouros DVM', 'rex.swaniawski@example.org', 7, 5, 46931, 21, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(77, 'Opal McClure III', 'lily.hand@example.net', 3, 2, 46241, 15, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(78, 'Muriel Moen MD', 'assunta.cremin@example.com', 2, 5, 48982, 18, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(79, 'Bernardo Mante I', 'ihowe@example.net', 4, 4, 42558, 19, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(80, 'Claudie Schamberger', 'whitney08@example.com', 3, 3, 40201, 14, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(81, 'Rosemary Renner', 'rory.hill@example.org', 3, 4, 41037, 22, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(82, 'Dayana Kuvalis', 'john52@example.org', 5, 3, 40773, 13, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(83, 'Gabriel Braun', 'russel.tierra@example.com', 6, 2, 41866, 4, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(84, 'John Mohr Sr.', 'brakus.lonie@example.com', 6, 1, 41927, 5, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(85, 'Prof. Zion Von DDS', 'aiden.kilback@example.com', 5, 3, 49922, 3, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(86, 'Clark Becker', 'anderson.stan@example.net', 5, 2, 48696, 18, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(87, 'Lulu Aufderhar', 'xhowell@example.org', 2, 5, 41750, 1, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(88, 'Dr. Carmela Ryan', 'gweimann@example.org', 4, 2, 47753, 3, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(89, 'Greg McKenzie', 'jayda.wisoky@example.org', 7, 5, 41275, 16, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(90, 'Dr. Madisen Stamm PhD', 'adell41@example.org', 7, 2, 45980, 8, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(91, 'Dr. Bernardo Murazik DDS', 'eudora57@example.com', 1, 5, 45155, 15, NULL, 1, 'F', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(92, 'Miss Kacie Wolf II', 'llewellyn36@example.org', 2, 5, 41948, 21, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(93, 'Tamara Padberg', 'cledner@example.org', 6, 4, 46022, 7, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(94, 'Leone Boehm', 'pjohnson@example.com', 4, 2, 45066, 15, NULL, 1, 'M', '2021-09-14 19:55:37', '2021-09-14 19:55:37'),
(95, 'Christiana Bartell', 'johnathan.kunze@example.org', 5, 1, 43061, 8, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(96, 'Lemuel Smith IV', 'mable77@example.net', 1, 1, 46885, 1, NULL, 2, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(97, 'Meredith Hansen', 'llegros@example.org', 6, 2, 44280, 16, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(98, 'Miss Retha Jenkins V', 'rkihn@example.net', 4, 4, 41768, 6, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(99, 'Dr. Cicero Hermiston', 'ybotsford@example.org', 6, 1, 48598, 1, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(100, 'Hallie Schroeder', 'moore.danial@example.net', 5, 2, 44935, 17, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(101, 'Shaina Christiansen', 'stoltenberg.estella@example.com', 6, 4, 41726, 17, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(102, 'Susan Sauer', 'christa20@example.net', 5, 4, 46849, 7, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(103, 'Prof. Ludie Rosenbaum', 'osawayn@example.com', 3, 2, 41017, 17, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(104, 'Mr. Caesar Fahey', 'cornelius.connelly@example.net', 7, 2, 41316, 12, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(105, 'Celia Graham', 'lucious06@example.net', 2, 2, 48707, 21, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(106, 'Edwardo Johns', 'conroy.dariana@example.com', 5, 4, 49903, 12, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(107, 'Dr. Chesley Spinka', 'madonna.okeefe@example.com', 3, 1, 47706, 22, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(108, 'Katlynn Miller', 'xbrekke@example.com', 7, 2, 41985, 21, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(109, 'Lucious Tillman', 'schoen.michael@example.net', 5, 5, 41609, 17, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(110, 'Marisol Mertz I', 'augusta.funk@example.com', 1, 3, 46050, 12, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(111, 'Estel Considine', 'turner.aileen@example.net', 3, 2, 49993, 11, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(112, 'Santa Kunde', 'celestino27@example.net', 3, 3, 45675, 17, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(113, 'Yessenia Haag', 'fmcglynn@example.com', 4, 3, 49850, 3, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(114, 'Schuyler Kessler', 'orpha.strosin@example.com', 2, 3, 44582, 4, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(115, 'Wilburn McGlynn', 'gislason.marlon@example.com', 2, 3, 46949, 5, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(116, 'Dr. Durward Metz IV', 'gerdman@example.org', 1, 1, 42983, 20, NULL, 2, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(117, 'Miss Zoila Hermann MD', 'kamren.labadie@example.net', 6, 4, 47496, 9, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(118, 'Novella Kessler', 'michel62@example.net', 5, 4, 47707, 4, NULL, 1, 'F', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(119, 'Kattie Hill', 'roderick.wolff@example.com', 1, 2, 49627, 18, NULL, 1, 'M', '2021-09-14 19:55:38', '2021-09-14 19:55:38'),
(120, 'Shany Koepp', 'greenholt.grant@example.org', 5, 2, 47284, 15, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(121, 'Marty Streich', 'krobel@example.net', 1, 5, 40385, 17, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(122, 'Jamir Blanda', 'lehner.jamel@example.com', 1, 2, 40789, 7, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(123, 'Ms. Nya Blick', 'peter04@example.net', 4, 3, 41187, 22, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(124, 'Eugene Hessel', 'leffler.carli@example.net', 5, 2, 42300, 2, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(125, 'Baby Batz', 'gabrielle89@example.com', 7, 2, 44498, 3, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(126, 'Selmer Zieme', 'orn.adaline@example.com', 6, 2, 49216, 2, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(127, 'Dawn Ward', 'kassulke.kavon@example.net', 2, 5, 45390, 6, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(128, 'Joyce Larson', 'maya.weimann@example.net', 5, 1, 46112, 18, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(129, 'Kristopher Skiles', 'ustark@example.com', 5, 5, 42933, 19, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(130, 'Prof. Alejandrin Tromp MD', 'brigitte.walsh@example.org', 4, 1, 40026, 16, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(131, 'Miss Ines Daugherty', 'nrunolfsdottir@example.com', 7, 5, 42286, 11, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(132, 'Berta Nikolaus', 'earlene73@example.org', 1, 5, 41925, 10, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(133, 'Wilhelmine Johns', 'xrunolfsson@example.net', 3, 3, 46581, 5, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(134, 'Dr. Juana Hill IV', 'hhowe@example.net', 3, 2, 47445, 7, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(135, 'Prof. Lawson Purdy I', 'amber57@example.net', 4, 2, 45496, 2, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(136, 'Dr. Scotty Parisian', 'crystal37@example.org', 4, 5, 48575, 8, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(137, 'Adolf Bode V', 'kavon78@example.net', 1, 4, 44971, 14, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(138, 'Beulah Schoen', 'jbraun@example.com', 7, 4, 47804, 21, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(139, 'Rocky Gorczany', 'plowe@example.org', 2, 2, 44507, 19, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(140, 'Kane Spinka', 'ijaskolski@example.com', 3, 2, 44241, 12, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(141, 'Ms. Rafaela Reilly III', 'johns.macie@example.com', 5, 1, 43361, 11, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(142, 'Stevie Witting', 'macejkovic.maddison@example.org', 7, 2, 44159, 21, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(143, 'Mr. Theron Kreiger', 'angelica55@example.net', 6, 2, 48523, 1, NULL, 1, 'M', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(144, 'Nelda Moen', 'eda77@example.org', 3, 2, 46337, 14, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(145, 'Miguel Rosenbaum', 'herzog.lucy@example.com', 4, 4, 49743, 13, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(146, 'Emmanuel Rogahn', 'shaylee12@example.com', 6, 2, 49343, 21, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(147, 'Dr. Hayden Bailey', 'franecki.reagan@example.org', 4, 1, 46197, 21, NULL, 1, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(148, 'Janet Schumm', 'nicklaus64@example.net', 1, 1, 40878, 14, NULL, 2, 'F', '2021-09-14 19:55:39', '2021-09-14 19:55:39'),
(149, 'Mr. Alf Goyette II', 'raphael.bode@example.com', 2, 2, 47840, 17, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(150, 'Lelia Cruickshank', 'misael76@example.net', 7, 5, 40238, 3, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(151, 'Mr. Mitchell Corwin', 'elemke@example.org', 6, 4, 47182, 14, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(152, 'Elsa Casper', 'lolson@example.com', 6, 5, 45918, 17, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(153, 'Ryleigh Hagenes', 'beer.norberto@example.net', 4, 3, 48836, 19, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(154, 'Mitchell Hills', 'krajcik.harrison@example.com', 3, 3, 45979, 9, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(155, 'Everett Hoeger', 'jaqueline.schamberger@example.com', 5, 1, 46026, 1, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(156, 'Dr. Kane O\'Reilly', 'vfarrell@example.net', 7, 2, 42112, 9, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(157, 'Kyra Quigley', 'spencer.lindsay@example.com', 7, 2, 41652, 15, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(158, 'Miss Meagan Shields V', 'waelchi.bonnie@example.com', 3, 3, 46119, 12, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(159, 'Anibal Runolfsson', 'kreiger.cleo@example.com', 6, 5, 42386, 5, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(160, 'Alaina Douglas', 'hayes.dax@example.net', 6, 1, 47836, 16, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(161, 'Prof. Florencio Rippin IV', 'jewell14@example.net', 2, 1, 41384, 4, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(162, 'Lydia Kreiger', 'ubergstrom@example.com', 6, 4, 48577, 22, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(163, 'Prof. Allene Heaney DDS', 'vkovacek@example.net', 7, 3, 40717, 6, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(164, 'Jeanette Kris III', 'brekke.madyson@example.net', 7, 1, 40302, 7, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(165, 'Mr. Dorthy Borer DVM', 'xabbott@example.com', 3, 5, 47595, 20, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(166, 'Jarrell Pollich', 'ona45@example.com', 6, 5, 49251, 1, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(167, 'Prof. Maia Tremblay IV', 'jordy.oconner@example.org', 7, 2, 44779, 4, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(168, 'Johanna Williamson IV', 'michel84@example.com', 5, 1, 48380, 16, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(169, 'Shanel Hayes', 'kirk.johnston@example.com', 2, 3, 46781, 14, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(170, 'Lauren Pfannerstill PhD', 'jacinto.blanda@example.net', 4, 4, 43643, 18, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(171, 'Garrick Jerde', 'xchristiansen@example.org', 7, 1, 40157, 2, NULL, 1, 'M', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(172, 'Quentin Metz', 'nmiller@example.com', 1, 3, 43514, 5, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(173, 'Mariah Volkman', 'jhartmann@example.com', 5, 4, 41505, 22, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(174, 'Aimee Robel DDS', 'carmel.franecki@example.org', 6, 4, 45047, 7, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(175, 'Meaghan Hagenes', 'harris.samir@example.net', 3, 1, 46582, 1, NULL, 1, 'F', '2021-09-14 19:55:40', '2021-09-14 19:55:40'),
(176, 'Elyssa Cummings', 'gusikowski.clare@example.com', 4, 1, 49255, 10, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(177, 'Prof. Houston Dietrich', 'rylan.conroy@example.net', 5, 3, 42440, 16, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(178, 'Stacy Berge', 'xkuvalis@example.org', 7, 2, 46143, 11, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(179, 'Carli Rolfson', 'khill@example.net', 2, 5, 42612, 7, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(180, 'Hilma Smitham', 'cole.etha@example.com', 5, 5, 49896, 20, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(181, 'Adolph Rohan', 'lexi.marvin@example.net', 5, 1, 45879, 3, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(182, 'Elisa D\'Amore', 'muhammad.turner@example.net', 4, 4, 48674, 3, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(183, 'Prof. Julien Grant V', 'cassin.vito@example.net', 6, 2, 42795, 9, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(184, 'Michel Herman', 'paris.effertz@example.net', 4, 3, 46290, 20, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(185, 'Miss Liana Glover', 'madelynn06@example.com', 1, 1, 47196, 16, NULL, 2, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(186, 'Katarina Balistreri', 'hermiston.marcelina@example.com', 3, 2, 46690, 7, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(187, 'Mattie Davis', 'fritsch.duane@example.org', 2, 3, 43290, 18, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(188, 'Dr. Diego Zieme II', 'lesch.carter@example.net', 4, 5, 46438, 18, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(189, 'Samir Bernier I', 'dock42@example.net', 5, 5, 49539, 15, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(190, 'Caleb Baumbach Sr.', 'geovanni.reichert@example.org', 1, 3, 44097, 22, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(191, 'Mr. Eusebio Wyman', 'gusikowski.arnulfo@example.com', 5, 2, 43656, 7, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(192, 'Larry Rolfson', 'angelita.ziemann@example.net', 3, 4, 46268, 1, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(193, 'Prof. Rudolph Boyle II', 'gvon@example.org', 1, 3, 49270, 10, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(194, 'Mr. Daren Heller', 'alice.schaefer@example.org', 2, 2, 49287, 15, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(195, 'Graham Koch', 'yoshiko.skiles@example.org', 7, 1, 42989, 1, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(196, 'Trinity Kovacek', 'jdare@example.com', 5, 4, 41163, 13, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(197, 'Mr. Erick Weimann', 'stracke.violette@example.net', 5, 1, 45367, 20, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(198, 'Dr. Hellen Heathcote', 'dach.jack@example.org', 5, 5, 43568, 8, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(199, 'Brandi Schinner MD', 'lubowitz.wava@example.net', 1, 2, 41944, 22, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(200, 'Jennings Keeling', 'carmen62@example.com', 5, 5, 47311, 22, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(201, 'Arlie Rolfson', 'hulda.deckow@example.net', 1, 3, 42475, 21, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(202, 'Rodolfo Boehm', 'dledner@example.org', 3, 2, 46803, 5, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(203, 'Prof. Rozella Herzog DVM', 'jorge65@example.org', 6, 1, 41610, 7, NULL, 1, 'M', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(204, 'Dr. Caterina Quitzon DDS', 'flavie.connelly@example.net', 6, 5, 49849, 6, NULL, 1, 'F', '2021-09-14 19:55:41', '2021-09-14 19:55:41'),
(205, 'Dr. Jasper Weimann', 'raleigh66@example.org', 3, 3, 49493, 10, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(206, 'Prof. Lucius Runolfsdottir', 'iparisian@example.com', 1, 2, 44681, 4, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(207, 'Gianni Koelpin', 'pconroy@example.net', 1, 4, 40881, 13, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(208, 'Arch Little', 'macie.kuphal@example.com', 3, 3, 44495, 22, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(209, 'Margret Hegmann Jr.', 'pfeffer.jermaine@example.com', 7, 2, 47780, 11, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(210, 'Queen Brakus', 'lysanne43@example.org', 3, 4, 48610, 6, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(211, 'Ms. Magdalena Breitenberg', 'nikolaus.grover@example.com', 5, 3, 44720, 11, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(212, 'Connor Cassin', 'xrogahn@example.org', 2, 2, 45085, 2, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(213, 'Jenifer Nienow', 'medhurst.emilio@example.net', 2, 1, 47111, 13, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(214, 'Dr. Leon Casper III', 'yherman@example.net', 1, 1, 40724, 8, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(215, 'Miss Marcella Goldner', 'buckridge.alexa@example.net', 6, 3, 41540, 22, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(216, 'Adaline VonRueden', 'funk.alfred@example.net', 5, 5, 43842, 4, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(217, 'Edward Boyle III', 'raleigh.koelpin@example.net', 6, 2, 43231, 1, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(218, 'Prince Schroeder', 'pacocha.herta@example.net', 6, 3, 48630, 22, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(219, 'Issac Schumm', 'ortiz.gwendolyn@example.net', 4, 2, 49944, 17, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(220, 'Mr. Allen Bednar', 'enrico84@example.com', 3, 5, 43159, 20, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(221, 'Timmy Haley', 'connor24@example.com', 4, 3, 44561, 3, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(222, 'Horace O\'Reilly', 'iframi@example.org', 6, 4, 47744, 4, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(223, 'Dr. Branson Hane', 'rippin.dejuan@example.com', 6, 1, 40169, 18, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(224, 'Dr. Ward Kautzer', 'ijakubowski@example.org', 2, 3, 44706, 17, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(225, 'Sedrick Wuckert Sr.', 'kuhlman.elian@example.net', 3, 3, 49594, 1, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(226, 'Jacklyn Lubowitz', 'monahan.michael@example.net', 1, 1, 48921, 4, NULL, 2, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(227, 'Brianne Metz', 'sklocko@example.net', 3, 5, 46031, 10, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(228, 'Ena Waters', 'okautzer@example.net', 1, 5, 42708, 20, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(229, 'Prof. Aric Fay III', 'keyshawn.labadie@example.org', 5, 1, 43965, 22, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(230, 'Dr. Mercedes O\'Hara I', 'plarkin@example.org', 1, 4, 40352, 2, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(231, 'Xander McDermott', 'marquardt.eryn@example.net', 2, 1, 42319, 15, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(232, 'Manuela Spencer', 'olang@example.com', 4, 4, 46317, 4, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(233, 'Dan Bins', 'bins.marcellus@example.net', 3, 4, 44225, 8, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(234, 'Mr. Emile Roob', 'quigley.garrison@example.com', 3, 2, 49458, 7, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(235, 'Genoveva Howell', 'nikolaus.aurelie@example.net', 7, 2, 42039, 6, NULL, 1, 'M', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(236, 'Prof. Lyric Gerlach Sr.', 'tlegros@example.net', 7, 4, 43741, 9, NULL, 1, 'F', '2021-09-14 19:55:42', '2021-09-14 19:55:42'),
(237, 'Virginia Gleason', 'vena77@example.org', 4, 1, 42375, 14, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(238, 'Justice Pfeffer', 'nettie.schneider@example.com', 5, 5, 45590, 18, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(239, 'Taurean Auer', 'flossie91@example.com', 2, 5, 42636, 10, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(240, 'Griffin Langworth', 'kkling@example.com', 3, 5, 45683, 7, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(241, 'Darryl Fadel', 'reagan12@example.net', 2, 3, 47439, 16, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(242, 'Richie Robel Jr.', 'samara.oreilly@example.org', 4, 3, 44392, 5, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(243, 'Elisabeth Nicolas II', 'bharber@example.com', 2, 3, 42013, 9, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(244, 'Ada Crist', 'cummings.rosella@example.com', 3, 3, 48754, 14, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(245, 'Naomie Armstrong', 'hilbert92@example.net', 7, 1, 43849, 13, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(246, 'Dr. Kameron Lindgren DVM', 'wstark@example.org', 4, 2, 47972, 20, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(247, 'Prof. Trace Legros', 'rau.maureen@example.com', 7, 1, 40937, 2, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(248, 'Aurelio Langosh', 'adolf37@example.net', 6, 4, 46048, 9, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(249, 'Dr. Maximus Rosenbaum', 'cmarvin@example.com', 5, 3, 45759, 20, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(250, 'Noemie Marvin MD', 'priscilla16@example.com', 6, 5, 42600, 11, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(251, 'Kaylin Yost', 'owhite@example.org', 2, 2, 41215, 22, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(252, 'Adrienne Buckridge', 'jazmyne68@example.net', 4, 4, 42644, 1, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(253, 'Lilyan Daugherty', 'sarai22@example.org', 7, 2, 47080, 8, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(254, 'Esperanza Sporer', 'guadalupe50@example.net', 6, 1, 44040, 10, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(255, 'Keegan Windler', 'jalon22@example.com', 3, 1, 44488, 13, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(256, 'Keaton Streich', 'swaters@example.org', 5, 3, 48681, 10, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(257, 'Armando Berge', 'tremblay.emily@example.com', 7, 1, 41932, 21, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(258, 'Victor Bashirian', 'reagan.bernhard@example.org', 3, 1, 43106, 6, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(259, 'Mrs. Lila Medhurst', 'sincere98@example.org', 7, 5, 43874, 6, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(260, 'Davon Marvin', 'dkassulke@example.org', 3, 2, 47213, 2, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(261, 'Pansy Schoen', 'wiza.daniella@example.org', 3, 3, 48300, 8, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(262, 'Woodrow Raynor', 'gwendolyn.murphy@example.net', 1, 2, 40547, 16, NULL, 1, 'M', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(263, 'Shanie Braun', 'denesik.camila@example.net', 2, 1, 41488, 7, NULL, 1, 'F', '2021-09-14 19:55:43', '2021-09-14 19:55:43'),
(264, 'Tyrell Ritchie', 'shanelle.murphy@example.net', 5, 2, 49690, 1, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(265, 'Mr. Bud Kub', 'rosemarie20@example.com', 7, 3, 41955, 15, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(266, 'Viva Heaney', 'fsanford@example.org', 3, 3, 47136, 9, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(267, 'Dr. Bud DuBuque', 'lhilpert@example.net', 3, 2, 45186, 9, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(268, 'Brionna Hamill', 'tyson.oconner@example.com', 4, 3, 49947, 17, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(269, 'Garrett Hoppe', 'harris.rachael@example.net', 3, 4, 43218, 16, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(270, 'Aniyah Olson', 'elena71@example.org', 2, 5, 49835, 18, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(271, 'Mr. Ashton Turner', 'evan34@example.org', 6, 3, 44209, 6, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(272, 'Dr. Mavis Casper II', 'darby.rempel@example.net', 1, 4, 48262, 12, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(273, 'Lia Torphy', 'sincere59@example.org', 4, 2, 49110, 16, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(274, 'Hassie Rodriguez MD', 'rogahn.shayne@example.com', 3, 5, 49792, 5, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(275, 'Laron Kris PhD', 'bins.logan@example.org', 3, 3, 41233, 18, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(276, 'Mrs. Samanta Stroman', 'ashly.sporer@example.net', 1, 5, 41136, 19, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(277, 'Mr. Lonny O\'Kon II', 'birdie99@example.org', 7, 3, 46442, 15, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(278, 'Dr. Sven Hauck', 'dax.ledner@example.net', 1, 1, 48614, 2, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(279, 'Ms. Era Fay', 'satterfield.trevor@example.org', 2, 1, 43065, 14, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(280, 'Muriel Okuneva', 'hanna.morar@example.com', 2, 4, 46187, 2, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(281, 'Finn Mayert', 'umitchell@example.com', 1, 5, 46748, 17, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(282, 'Lisette Heidenreich', 'cleveland.bahringer@example.org', 3, 2, 46747, 11, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(283, 'Mr. Alexzander Kunde Sr.', 'eokeefe@example.org', 4, 2, 45062, 10, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(284, 'Miss Zoila Beahan', 'reese64@example.org', 2, 1, 47825, 10, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(285, 'Mandy Marvin', 'simeon13@example.org', 5, 3, 43166, 12, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(286, 'Danny Lowe', 'whoeger@example.com', 1, 4, 46030, 4, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(287, 'Verna Schaden', 'lexie.braun@example.net', 2, 5, 47761, 19, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(288, 'Kelvin Schimmel', 'lrunte@example.com', 3, 2, 49313, 6, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(289, 'Wilfrid Casper', 'oquitzon@example.org', 1, 5, 41058, 17, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(290, 'Jessika Witting', 'susana35@example.org', 1, 4, 40305, 10, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(291, 'Brisa Wisoky', 'vito.altenwerth@example.net', 6, 2, 49507, 9, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(292, 'Malcolm Orn I', 'kieran76@example.com', 4, 1, 43858, 15, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(293, 'Amiya Monahan', 'hassie96@example.net', 7, 5, 44888, 17, NULL, 1, 'F', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(294, 'Kyle Donnelly III', 'claudine70@example.org', 7, 3, 49083, 5, NULL, 1, 'M', '2021-09-14 19:55:44', '2021-09-14 19:55:44'),
(295, 'Mrs. Lela Parker Sr.', 'dale.baumbach@example.net', 7, 5, 46644, 5, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(296, 'Marisa Hayes', 'clittel@example.net', 1, 5, 46682, 13, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(297, 'Miss Daniella Mertz', 'ullrich.carlos@example.net', 4, 2, 44300, 15, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(298, 'Isabel Ryan V', 'iankunding@example.org', 3, 1, 41631, 11, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(299, 'Carson Durgan', 'dovie.murray@example.net', 6, 5, 42036, 22, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(300, 'Ms. Cassandre Weissnat DDS', 'jodie.wehner@example.org', 6, 3, 43918, 2, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(301, 'Ms. Selina McLaughlin', 'ahessel@example.net', 4, 4, 40651, 14, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(302, 'Carrie Ritchie Sr.', 'gaylord.schiller@example.org', 4, 3, 48404, 20, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(303, 'Kali Hegmann', 'drew68@example.org', 3, 4, 41831, 10, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(304, 'Dr. Magnus Flatley Jr.', 'mwalsh@example.com', 1, 2, 42958, 4, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(305, 'Prof. Jackeline Zieme Sr.', 'tyrique62@example.com', 2, 1, 44923, 21, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(306, 'Dr. Daphne Jaskolski', 'kyra.haag@example.org', 1, 4, 49818, 17, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(307, 'Armando Reichel', 'schowalter.magnolia@example.com', 7, 3, 40047, 22, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(308, 'Wilford Osinski', 'jbogisich@example.com', 7, 5, 46607, 12, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(309, 'Geo Kassulke', 'reichert.emelie@example.net', 3, 5, 49543, 6, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(310, 'Danial Schowalter', 'jones.rey@example.com', 1, 3, 41884, 20, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(311, 'Taryn Brekke II', 'bosco.elwin@example.org', 6, 4, 46601, 7, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(312, 'Taurean Hoeger', 'keenan.stracke@example.com', 2, 2, 40358, 12, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(313, 'Lauren Graham', 'mann.dulce@example.org', 2, 2, 44729, 3, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(314, 'Maryse Hessel', 'lgrimes@example.net', 6, 1, 40999, 6, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(315, 'Marlon Balistreri', 'bins.ruthe@example.com', 6, 2, 44234, 17, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(316, 'Mrs. Marian Schulist DVM', 'taurean71@example.org', 5, 5, 43177, 14, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(317, 'Alphonso Strosin', 'dameon.beahan@example.net', 7, 4, 49631, 18, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(318, 'Mr. Alfonzo Mohr IV', 'hauck.erika@example.org', 4, 5, 42432, 22, NULL, 1, 'F', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(319, 'Savion Quitzon', 'caleigh76@example.com', 3, 5, 44156, 21, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(320, 'Daniella Reichert', 'burdette.sipes@example.org', 6, 1, 45639, 17, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(321, 'Lula Considine', 'lebsack.rosalind@example.org', 6, 4, 41886, 2, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(322, 'Deron Spinka', 'letha75@example.com', 3, 1, 49419, 8, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(323, 'Monserrat Hermiston', 'baumbach.vince@example.org', 3, 3, 45178, 16, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(324, 'Miss Madilyn Altenwerth IV', 'savanna.gibson@example.net', 6, 5, 47905, 16, NULL, 1, 'M', '2021-09-14 19:55:45', '2021-09-14 19:55:45'),
(325, 'Earl Conn DVM', 'sean.raynor@example.com', 1, 1, 45264, 5, NULL, 2, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(326, 'Lyda Miller PhD', 'vstracke@example.net', 6, 2, 43289, 21, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(327, 'Joaquin Roberts IV', 'allen.cruickshank@example.org', 1, 2, 46068, 12, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(328, 'Junius Okuneva', 'bpagac@example.com', 1, 3, 41854, 14, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(329, 'Grayson Wolff', 'jarret97@example.org', 4, 3, 49262, 10, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(330, 'Prof. Francisco Gleason', 'chaim.jast@example.net', 2, 5, 47477, 7, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(331, 'Darrion Wisoky', 'lawrence64@example.org', 1, 1, 43377, 7, NULL, 2, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(332, 'Ms. Verla Hane MD', 'leannon.margaret@example.org', 1, 5, 46346, 18, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(333, 'Alyce Kilback', 'vkihn@example.com', 3, 1, 40749, 18, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(334, 'Bernita Volkman', 'beatrice21@example.net', 4, 2, 47883, 20, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(335, 'Mariam Mraz', 'jcarter@example.net', 7, 4, 48945, 2, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(336, 'Josh Gibson', 'mann.oleta@example.org', 2, 4, 45416, 8, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(337, 'Abdullah Crist', 'braulio88@example.org', 7, 3, 46800, 17, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(338, 'Prof. Kailey Streich', 'nia.gutkowski@example.org', 4, 5, 43482, 22, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(339, 'Leta Hauck DDS', 'guido82@example.com', 7, 3, 49889, 15, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(340, 'Dr. Tomas Hand', 'johnnie.harris@example.org', 3, 2, 45179, 2, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(341, 'Talon Reichert IV', 'jarret52@example.net', 5, 4, 48671, 13, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(342, 'Adrianna Leuschke', 'loren.cormier@example.org', 5, 3, 40419, 2, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(343, 'Jules Spencer', 'pietro.tromp@example.net', 3, 3, 43096, 7, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(344, 'Mr. Mohamed Paucek', 'tremblay.cullen@example.net', 1, 1, 40895, 8, NULL, 2, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(345, 'Emmanuel Farrell', 'kuphal.neil@example.com', 2, 5, 43250, 15, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(346, 'Isaias Kuhlman', 'lamar.toy@example.org', 1, 5, 41192, 9, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(347, 'Tristin Jones', 'metz.stefanie@example.net', 4, 4, 42551, 7, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(348, 'Jerrod Sipes', 'tyree.strosin@example.net', 2, 4, 41223, 19, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(349, 'Ezequiel Koss I', 'porn@example.org', 7, 1, 46207, 13, NULL, 1, 'F', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(350, 'Kristoffer Williamson', 'tremaine35@example.com', 3, 3, 45824, 7, NULL, 1, 'M', '2021-09-14 19:55:46', '2021-09-14 19:55:46'),
(351, 'Md. Kawsar Ahmed', 'kawsar44@gmail.com', 1, 1, 41134, 1, 101, 2, 'M', '2021-09-14 20:07:28', '2021-09-14 20:12:06'),
(352, 'Maruf Hosen', 'maruf44@gmail.com', 1, 1, 41144, 1, NULL, 2, 'M', '2021-09-14 20:07:28', '2021-09-14 20:07:28'),
(353, 'Md. Obydullah Sarder', 'iamsarder21@gmail.com', 1, 1, 41148, 1, NULL, 3, 'M', '2021-09-14 20:07:28', '2021-09-15 17:00:48'),
(354, 'S. M. Parvez Jewel', 'parvez44@gmail.com', 1, 1, 41428, 1, NULL, 2, 'M', '2021-09-14 20:07:29', '2021-09-14 20:07:29'),
(355, 'Afrin Ahmed Eva', 'eva44@gmail.com', 1, 1, 41140, 2, NULL, 2, 'F', '2021-09-14 20:07:29', '2021-09-14 20:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'debit',
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `name`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(1, 5, 'Add Money', 'Credit', 100.00, '2021-09-14 20:17:00', '2021-09-14 20:17:00'),
(2, 3, 'TopUp Money for (Md. Obydullah Sarder)', 'Credit', 100.00, '2021-09-14 20:17:00', '2021-09-14 20:17:00'),
(3, 5, 'Buy Food Coupon (2021-09-16-L)', 'Debit', 20.00, '2021-09-14 20:43:30', '2021-09-14 20:43:30'),
(4, 4, 'Sold Food Coupon (2021-09-16-353-L)', 'Debit', 20.00, '2021-09-14 20:43:30', '2021-09-14 20:43:30'),
(5, 5, 'Buy Food Coupon (2021-09-16-D)', 'Debit', 20.00, '2021-09-14 20:53:37', '2021-09-14 20:53:37'),
(6, 4, 'Sold Food Coupon (2021-09-16-353-D)', 'Debit', 20.00, '2021-09-14 20:53:37', '2021-09-14 20:53:37'),
(7, 4, 'Received Payment', 'Credit', 40.00, '2021-09-14 20:59:53', '2021-09-14 20:59:53'),
(8, 3, 'Make Payment (Dining)', 'Debit', 40.00, '2021-09-14 20:59:53', '2021-09-14 20:59:53'),
(9, 5, 'Pay Hall Bill ( September-2021 to October-2021 )', 'Debit', 40.00, '2021-09-14 21:02:21', '2021-09-14 21:02:21'),
(10, 1, 'Hall Bill Pending (RTH)', 'Debit', 40.00, '2021-09-14 21:02:22', '2021-09-14 21:02:22'),
(11, 1, 'Received Hall Bill (RTH)', 'Credit', 15.00, '2021-09-14 21:23:32', '2021-09-14 21:23:32'),
(12, 3, 'Paid Hall Bill To Register', 'Debit', 15.00, '2021-09-14 21:23:32', '2021-09-14 21:23:32'),
(13, 1, 'Received Hall Bill (RTH)', 'Credit', 25.00, '2021-09-14 21:25:07', '2021-09-14 21:25:07'),
(14, 3, 'Paid Hall Bill To Register', 'Debit', 25.00, '2021-09-14 21:25:07', '2021-09-14 21:25:07'),
(15, 5, 'Food Coupon Reversal (2021-09-16-D)', 'Credit', 20.00, '2021-09-15 10:58:31', '2021-09-15 10:58:31'),
(16, 4, 'Sold Food Coupon Reversal (2021-09-16-353-D)', 'Credit', 20.00, '2021-09-15 10:58:31', '2021-09-15 10:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Md. Register', 'register@gmail.com', '$2y$10$t4F1AGrKzraMQ8djtREuTuvHLqPHJSlwsRT9/11H.QRF.D.3yru.m', NULL, NULL, NULL),
(2, 2, 'Institute of Information Technology', 'iit-office@gmail.com', '$2y$10$wWZ.y3Xum5QqpGV2gbrBRuWDG56Gh0O/R9GaGA..i4eFiE7qkV7cu', NULL, NULL, NULL),
(3, 3, 'Rabindranath Tagore Hall', 'rth_office@gmail.com', '$2y$10$0gNRpqId.WeJ4O810/Z20O3sfdF5kq/3nvLT6e85xNlBGjNH8FKPG', NULL, NULL, NULL),
(4, 5, 'Rabindranath Tagore Hall Dining', 'rth_dining@gmail.com', '$2y$10$jbumBxy516/Wr6dL.AFmTOY.Y9lnYBLoqaC4.U.ZewbG5hc99uLQG', NULL, NULL, NULL),
(5, 4, 'Md. Obydullah Sarder', 'iamsarder21@gmail.com', '$2y$10$bud39mi8Ivqc4RVoWCaqI.LDGa7Zr6OykR2MKPMqyZIqZAl6X.qMm', NULL, '2021-09-14 20:13:47', '2021-09-14 20:13:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_details`
--
ALTER TABLE `coupon_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_details_coupon_no_unique` (`coupon_no`);

--
-- Indexes for table `depts`
--
ALTER TABLE `depts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `depts_name_unique` (`name`),
  ADD UNIQUE KEY `depts_short_name_unique` (`short_name`);

--
-- Indexes for table `dinings`
--
ALTER TABLE `dinings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dinings_email_unique` (`email`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `halls_name_unique` (`name`),
  ADD UNIQUE KEY `halls_short_name_unique` (`short_name`);

--
-- Indexes for table `hall_bills`
--
ALTER TABLE `hall_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hall_rooms`
--
ALTER TABLE `hall_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sessions_name_unique` (`name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD KEY `students_dept_id_foreign` (`dept_id`),
  ADD KEY `students_session_id_foreign` (`session_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupon_details`
--
ALTER TABLE `coupon_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `depts`
--
ALTER TABLE `depts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dinings`
--
ALTER TABLE `dinings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hall_bills`
--
ALTER TABLE `hall_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hall_rooms`
--
ALTER TABLE `hall_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_dept_id_foreign` FOREIGN KEY (`dept_id`) REFERENCES `depts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

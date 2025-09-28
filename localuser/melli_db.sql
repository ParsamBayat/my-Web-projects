-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 03:47 PM
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
-- Database: `melli_db`
-- Developer : "ParsaBayat"
--

-- --------------------------------------------------------

--
-- Table structure for table `melli_codes`
--

CREATE TABLE `melli_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `valid` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `melli_codes`
--

INSERT INTO `melli_codes` (`id`, `code`, `valid`, `created_at`) VALUES
(1, '2520256575', 1, '2025-09-28 13:22:35'),
(2, '2520256575', 1, '2025-09-28 13:22:38'),
(4, '2520256575', 1, '2025-09-28 13:42:01'),
(5, '0000000000', 0, '2025-09-28 13:43:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `melli_codes`
--
ALTER TABLE `melli_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `melli_codes`
--
ALTER TABLE `melli_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

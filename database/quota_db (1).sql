-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 06:26 AM
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
-- Database: `quota_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `matrix_no` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `college` varchar(50) NOT NULL,
  `year_of_study` int(11) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `merit` int(11) DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `matrix_no`, `name`, `college`, `year_of_study`, `gender`, `merit`, `status`, `submitted_at`) VALUES
(1, 'A23CS0921', 'Ali Bin Abu', 'KTR', 2, 'male', 77, 'approved', '2025-06-17 22:27:15'),
(2, 'A23CS0921', 'Hafiz Mamu', 'KTR', 2, 'male', 33, 'rejected', '2025-06-17 22:30:29'),
(3, 'A22CS0300', 'Siti Nur Aina', 'KTDI', 3, 'female', 89, 'approved', '2025-06-17 22:30:29'),
(4, 'A21CS0155', 'Ling Tian', 'KTC', 4, 'male', 92, 'approved', '2025-06-17 22:30:29'),
(5, 'A22CS0010', 'Ahmad Hafiz', 'Kolej 2', 2, 'male', 85, 'approved', '2025-06-17 18:07:15'),
(6, 'A22CS0020', 'Nur Aisyah', 'Kolej 4', 1, 'female', 72, 'pending', '2025-06-17 18:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(2, 'must above 50 merit', '60'),
(3, 'quota_criteria', 'Students must have a merit score above 50, with a minimum of 2 college event participation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

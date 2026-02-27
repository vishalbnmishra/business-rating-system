-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 04:22 PM
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
-- Database: `busineess_ratings`
--

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(255) DEFAULT NULL,
  `b_address` text DEFAULT NULL,
  `b_phone` varchar(20) DEFAULT NULL,
  `b_email` varchar(100) DEFAULT NULL,
  `b_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`b_id`, `b_name`, `b_address`, `b_phone`, `b_email`, `b_created_at`) VALUES
(4, 'fonics test 02', 'vashi 12', '9198974562', 'jard@gmail.com', '2026-02-27 11:22:41'),
(8, 'raj', '15', '9945678925', 'jardonj@gmail.com', '2026-02-27 12:33:44'),
(10, 'mnknk', 'ff', '9875575450', 'city13@gmail.com', '2026-02-27 12:56:46'),
(11, 'vishal', 'fr', '9198974564', 'jardo@gmail.com', '2026-02-27 13:54:08'),
(12, 'uk', 'ko', '9541236987', 'john13@gmail.com', '2026-02-27 14:00:24'),
(19, 'te', 'fgg', '9198974781', 'sneh@gmail.com', '2026-02-27 15:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `r_id` int(11) NOT NULL,
  `b_id` int(11) DEFAULT NULL,
  `r_name` varchar(255) DEFAULT NULL,
  `r_email` varchar(100) DEFAULT NULL,
  `r_phone` varchar(20) DEFAULT NULL,
  `r_ratings` decimal(2,1) DEFAULT NULL,
  `r_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`r_id`, `b_id`, `r_name`, `r_email`, `r_phone`, `r_ratings`, `r_created_at`) VALUES
(1, 4, 's', 's@gmail.com', '56789043221', 2.5, '2026-02-27 13:31:08'),
(2, 4, 's', 's@gmail.com', '56789043221', 2.5, '2026-02-27 13:31:23'),
(7, 10, 'gh', 'hhh@gmail.com', '56789043222', 3.5, '2026-02-27 14:53:27'),
(8, 8, 'vm', 'su@gmail.com', '56789043223', 3.5, '2026-02-27 14:53:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `fk_business` (`b_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_business` FOREIGN KEY (`b_id`) REFERENCES `business` (`b_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

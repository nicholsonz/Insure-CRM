-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2024 at 06:13 PM
-- Server version: 10.11.6-MariaDB-0+deb12u1-log
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clientdb`
--
CREATE DATABASE IF NOT EXISTS `clientdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `clientdb`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(50) DEFAULT '',
  `acct_type` varchar(75) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acct_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `address` varchar(55) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `county` varchar(25) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `phone_sec` varchar(20) NOT NULL,
  `email` varchar(55) DEFAULT NULL,
  `partA_date` date DEFAULT NULL,
  `partB_date` date DEFAULT NULL,
  `medicare_number` varchar(20) DEFAULT NULL,
  `policy` varchar(25) DEFAULT NULL,
  `insurer` varchar(25) DEFAULT NULL,
  `appstatus` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `acct_id` (`acct_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE IF NOT EXISTS `leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acct_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `address` varchar(55) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `county` varchar(25) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `phone_sec` varchar(20) NOT NULL,
  `email` varchar(55) DEFAULT NULL,
  `partA_date` date DEFAULT NULL,
  `partB_date` date DEFAULT NULL,
  `medicare_number` varchar(25) DEFAULT NULL,
  `policy` varchar(20) DEFAULT NULL,
  `insurer` varchar(20) DEFAULT NULL,
  `appstatus` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tally`
--

CREATE TABLE IF NOT EXISTS `tally` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `clients` int(6) DEFAULT NULL,
  `leads` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `client_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `acct_id` int(11) NOT NULL,
  `task_name` varchar(150) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  `details` text NOT NULL,
  `list_id` int(11) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `deadline` date NOT NULL,
  `type` enum('Lead','Client','Other') NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `list_id` (`list_id`),
  KEY `acct_id` (`acct_id`),
  KEY `client_id` (`client_id`),
  KEY `lead_id` (`lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_lists`
--

CREATE TABLE IF NOT EXISTS `task_lists` (
  `list_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `acct_id` int(11) NOT NULL,
  `list_name` varchar(50) NOT NULL,
  `list_description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`list_id`),
  KEY `acct_id` (`acct_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`acct_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`acct_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`acct_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_lists`
--
ALTER TABLE `task_lists`
  ADD CONSTRAINT `task_lists_ibfk_1` FOREIGN KEY (`acct_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`zach`@`localhost` EVENT `AnnualReview` ON SCHEDULE EVERY 1 YEAR STARTS '2024-10-15 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO `tasks`(`task_name`, `name`, `task_description`, `list_id`, `priority`, `deadline`, `type`) SELECT 'Call', name, 'Annual Review', '3', 'Medium', DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH), 'Client' FROM clients WHERE policy = ('Med Adv') OR policy = ('Med Supp')$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql.tulpelodge.org
-- Generation Time: Mar 27, 2020 at 07:02 AM
-- Server version: 5.7.28-log
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unitelections`
--

-- --------------------------------------------------------

--
-- Table structure for table `eligibleScouts`
--

DROP TABLE IF EXISTS `eligibleScouts`;
CREATE TABLE IF NOT EXISTS `eligibleScouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitId` int(11) NOT NULL,
  `lastName` text,
  `firstName` text,
  `rank` text,
  `isElected` tinyint(1) NOT NULL DEFAULT '0',
  `dob` date DEFAULT NULL,
  `address_line1` text,
  `address_line2` text,
  `city` text,
  `state` text,
  `zip` text,
  `phone` text,
  `email` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unitElections`
--

DROP TABLE IF EXISTS `unitElections`;
CREATE TABLE IF NOT EXISTS `unitElections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitNumber` int(11) DEFAULT NULL,
  `unitCommunity` text,
  `chapter` text,
  `sm_name` text,
  `sm_address_line1` text,
  `sm_address_line2` text,
  `sm_city` text,
  `sm_state` text,
  `sm_zip` text,
  `sm_email` text,
  `sm_phone` text,
  `numRegisteredYouth` int(11) DEFAULT NULL,
  `dateOfElection` date DEFAULT NULL,
  `accessKey` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `unitElections`
--
DROP TRIGGER IF EXISTS `unitAccessKey`;
DELIMITER $$
CREATE TRIGGER `unitAccessKey` BEFORE INSERT ON `unitElections` FOR EACH ROW BEGIN
  IF new.accessKey IS NULL THEN
    SET new.accessKey = uuid();
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitId` int(11) NOT NULL,
  `submissionId` int(11) NOT NULL,
  `scoutId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

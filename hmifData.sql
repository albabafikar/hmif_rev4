-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2016 at 07:53 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.6.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hmifData`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` int(128) NOT NULL,
  `status` int(128) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `role`, `status`, `created_at`, `last_login`) VALUES
(4, 'dito', '$2y$10$JMgya8GsVbohHbcNHDrziOEQ6PEzHqKMRd4L70oD.S7z0x76LPpia', 0, 0, '2016-03-12 16:36:48', '2016-03-17 03:56:34'),
(6, 'afif', '$2y$10$Jm4OnbZCJYZR7DaTks/SNuYd0KylxwCReCTxK6e63MAl7D6U1R.ne', 0, 1, '2016-03-12 17:01:41', '2016-03-16 14:39:16'),
(7, 'anshori', '$2y$10$m12R53SDUQTfKOINtlrfiOgQ.EEOC8i6N5tfwEtWVX/27OYHFrFe2', 1, 0, '2016-03-16 14:39:16', '2016-03-17 03:03:32'),
(9, 'jimmyfish', '$2y$10$vJo6uqIlnCM3JroxeYUKk.2KINKRcu9t7oplwSeO2yqWW0lTUe8CO', 0, 1, '2016-03-16 22:30:23', '2016-03-16 22:30:23'),
(10, 'fish', '$2y$10$Y71G1AcYGvNRuqGHZHx1xOoEOnM01Klcw/Z0qy5UuOW91Co.uLcL2', 1, 0, '2016-03-16 22:34:59', '2016-03-16 22:34:59'),
(12, 'asrul', '$2y$10$8MYxK3JLl9mJAHQKgvUXSOwTrYRPTczZEUeo1hzW4RwpqYm/NMTdm', 1, 0, '2016-03-17 04:14:32', '2016-03-17 04:14:32');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

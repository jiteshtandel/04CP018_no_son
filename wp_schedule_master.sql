-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2014 at 06:28 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_schedule_master`
--

CREATE TABLE IF NOT EXISTS `wp_schedule_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(10) NOT NULL,
  `start_time_abbr` varchar(4) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `end_time_abbr` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `wp_schedule_master`
--

INSERT INTO `wp_schedule_master` (`id`, `start_time`, `start_time_abbr`, `end_time`, `end_time_abbr`) VALUES
(1, '00:00', 'AM', '01:00', 'AM'),
(2, '01:00', 'AM', '02:00', 'AM'),
(3, '02:00', 'AM', '03:00', 'AM'),
(4, '03:00', 'AM', '04:00', 'AM'),
(5, '04:00', 'AM', '05:00', 'AM'),
(6, '05:00', 'AM', '06:00', 'AM'),
(7, '06:00', 'AM', '07:00', 'AM'),
(8, '07:00', 'AM', '08:00', 'AM'),
(9, '08:00', 'AM', '09:00', 'AM'),
(10, '09:00', 'AM', '10:00', 'AM'),
(11, '10:00', 'AM', '11:00', 'AM'),
(12, '11:00', 'AM', '12:00', 'PM'),
(13, '12:00', 'PM', '01:00', 'PM'),
(14, '01:00', 'PM', '02:00', 'PM'),
(15, '02:00', 'PM', '03:00', 'PM'),
(16, '03:00', 'PM', '04:00', 'PM'),
(17, '04:00', 'PM', '05:00', 'PM'),
(18, '05:00', 'PM', '06:00', 'PM'),
(19, '06:00', 'PM', '07:00', 'PM'),
(20, '07:00', 'PM', '08:00', 'PM'),
(21, '08:00', 'PM', '09:00', 'PM'),
(22, '09:00', 'PM', '10:00', 'PM'),
(23, '10:00', 'PM', '11:00', 'PM'),
(24, '11:00', 'PM', '00:00', 'AM');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2021 at 09:11 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `misc`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact1`
--

CREATE TABLE `contact1` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(128) DEFAULT NULL,
  `message` varchar(128) DEFAULT NULL,
  `permission` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact1`
--

INSERT INTO `contact1` (`contact_id`, `name`, `email`, `phone`, `message`, `permission`) VALUES
(1, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540', 'test', 'yes'),
(2, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540g', 'db', 'yes'),
(3, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540', 'vv', 'yes'),
(4, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540ss', 'dscv', 'yes'),
(5, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+491763672354a', 'sd', 'yes'),
(6, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540v', 'c', 'yes'),
(7, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540', 'gsdrg', 'yes'),
(8, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '017636723540', 'ddjdj', 'yes'),
(9, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '4917636723540', 'mfkfk', 'yes'),
(10, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '4917636723540', 'cac', 'yes'),
(11, 'Md Shohanoor Rahman', 'srnasib@gmail.com', '017676497855', 'z  c ', 'yes'),
(12, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '4917636723540', 'njfcnjf', 'yes'),
(13, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540', 'fnf', 'yes'),
(14, 'MD SHOHANOOR RAHMAN', 'srnasib@gmail.com', '+4917636723540', 'ndn', 'yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact1`
--
ALTER TABLE `contact1`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `name` (`name`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact1`
--
ALTER TABLE `contact1`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

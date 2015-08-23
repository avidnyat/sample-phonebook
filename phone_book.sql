-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2015 at 10:09 PM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `phone_details`
--

CREATE TABLE IF NOT EXISTS `phone_details` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `additional_notes` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phone_details`
--

INSERT INTO `phone_details` (`id`, `name`, `phone_number`, `additional_notes`, `date_created`, `date_updated`) VALUES
(25, 'Avidnyat Chiddarwar', '886 115 8210', 'Avidnyat''s number', '23 Aug 2015', '2015-08-23 22:03:40'),
(26, 'Shital Chiddarwar', '886 705 8210', 'Shital''s number', '23 Aug 2015', '2015-08-23 22:04:07'),
(27, 'Avilas Gupte', '9421377878', 'Friend''s number', '23 Aug 2015', '2015-08-23 22:04:39'),
(28, 'Nilesh Kandalwar', '9241618902', 'Friends number', '23 Aug 2015', '2015-08-23 22:05:17'),
(29, 'Prashant Kandalwar', '12345678', 'Brother''s number', '23 Aug 2015', '2015-08-23 22:05:49'),
(30, 'Divya Patil', '7878787878', 'My friends number', '23 Aug 2015', '2015-08-23 22:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `date_created`, `date_updated`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2015-08-21 00:00:00', '2015-08-21 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phone_details`
--
ALTER TABLE `phone_details`
  ADD PRIMARY KEY (`id`),
  ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `phone_details`
  ADD FULLTEXT KEY `name_2` (`name`,`phone_number`,`additional_notes`);
ALTER TABLE `phone_details`
  ADD FULLTEXT KEY `date_created` (`date_created`);
ALTER TABLE `phone_details`
  ADD FULLTEXT KEY `name_3` (`name`,`phone_number`,`additional_notes`,`date_created`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phone_details`
--
ALTER TABLE `phone_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2017 at 10:26 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ocms`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminpass`
--

CREATE TABLE `adminpass` (
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminpass`
--

INSERT INTO `adminpass` (`password`) VALUES
('admin');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_code` int(11) NOT NULL,
  `item_name` varchar(40) NOT NULL,
  `price` decimal(7,2) DEFAULT NULL,
  `tt_make` int(11) DEFAULT NULL,
  `availability` enum('0','1') DEFAULT '1',
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_code`, `item_name`, `price`, `tt_make`, `availability`, `count`) VALUES
(1, 'Samosa', '10.00', 0, '1', 100),
(2, 'Kachori', '10.00', 1, '1', 96),
(3, 'Bread Pakoda', '15.00', 2, '1', 97),
(4, 'Pastry', '30.00', 1, '1', 100);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `orderid` int(11) NOT NULL DEFAULT '0',
  `item_code` int(11) NOT NULL DEFAULT '0',
  `item_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`orderid`, `item_code`, `item_quantity`) VALUES
(1, 2, 2),
(2, 3, 1),
(3, 3, 1),
(4, 2, 1),
(5, 3, 1),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(11) NOT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `tt_complete` int(11) DEFAULT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(7,2) NOT NULL,
  `receipt` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `userid`, `tt_complete`, `order_time`, `price`, `receipt`) VALUES
(1, 'g1998agarwal@gmail.com', 2, '2017-11-06 08:14:09', '20.00', '1'),
(2, 'g1998agarwal@gmail.com', 2, '2017-11-06 08:14:18', '15.00', '1'),
(3, 'g1998agarwal@gmail.com', 2, '2017-11-06 08:14:28', '15.00', '1'),
(4, 'g1998agarwal@gmail.com', 1, '2017-11-06 08:44:34', '10.00', '1'),
(5, 'g1998agarwal@gmail.com', 2, '2017-11-06 08:50:12', '15.00', '1'),
(6, 'g1998agarwal@gmail.com', 1, '2017-11-06 08:50:23', '10.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `username` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`username`, `email`, `password`) VALUES
('Arun Siddarth', 'arunaaa099@gmail.com', 'abcd'),
('hbgvfdsa', 'chamanparauliya@gmail.com', '123'),
('Gunjan Agarwal', 'g1998agarwal@gmail.com', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminpass`
--
ALTER TABLE `adminpass`
  ADD PRIMARY KEY (`password`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_code`),
  ADD UNIQUE KEY `item_name` (`item_name`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`orderid`,`item_code`),
  ADD KEY `fk_orderitems2` (`item_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `fk_orders` (`userid`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `fk_orderitems1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`),
  ADD CONSTRAINT `fk_orderitems2` FOREIGN KEY (`item_code`) REFERENCES `items` (`item_code`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders` FOREIGN KEY (`userid`) REFERENCES `user_account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

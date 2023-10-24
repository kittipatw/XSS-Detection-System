-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 24, 2023 at 01:56 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `Detail_line`
--

CREATE TABLE `Detail_line` (
  `d_id` char(5) NOT NULL,
  `d_quantity` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `o_id` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Detail_line`
--

INSERT INTO `Detail_line` (`d_id`, `d_quantity`, `p_id`, `o_id`) VALUES
('1', 1, 104, '3275482125'),
('1', 2, 103, '3346352116'),
('1', 1, 105, '3666602697'),
('1', 1, 112, '4023176440'),
('1', 1, 102, '4792278009'),
('1', 1, 203, '6363154731'),
('1', 1, 202, '7271765977'),
('1', 1, 101, '7336717011'),
('1', 1, 118, '8661536431'),
('2', 1, 204, '3275482125'),
('2', 2, 110, '3346352116'),
('2', 1, 110, '3666602697'),
('2', 1, 111, '4023176440'),
('2', 1, 108, '4792278009'),
('2', 1, 211, '6363154731'),
('2', 1, 201, '7271765977'),
('2', 1, 102, '7336717011'),
('2', 2, 212, '8661536431'),
('3', 3, 116, '3275482125'),
('3', 1, 109, '3666602697'),
('3', 1, 208, '6363154731'),
('3', 1, 106, '7271765977'),
('3', 1, 103, '7336717011'),
('3', 1, 204, '8661536431'),
('4', 2, 109, '3275482125'),
('4', 3, 107, '7271765977'),
('4', 1, 104, '7336717011'),
('5', 1, 212, '7271765977'),
('5', 1, 105, '7336717011'),
('6', 1, 106, '7336717011');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `e_id` bigint(6) NOT NULL,
  `e_fname` varchar(20) NOT NULL,
  `e_lname` varchar(20) NOT NULL,
  `e_role` varchar(10) NOT NULL,
  `e_username` varchar(10) NOT NULL,
  `e_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`e_id`, `e_fname`, `e_lname`, `e_role`, `e_username`, `e_password`) VALUES
(111, 'Atikan', 'Mangkala', 'Admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(222, 'Kittipat', 'Wattanasuwan', 'Admin', 'admin2', '1c142b2d01aa34e9a36bde480645a57fd69e14155dacfab5a3f9257b77fdc8d8'),
(333, 'Elon2', 'Musk', 'Cashier', 'user0', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855');

-- --------------------------------------------------------

--
-- Table structure for table `Feedback`
--

CREATE TABLE `Feedback` (
  `e_id` bigint(6) DEFAULT NULL,
  `e_fname` varchar(20) DEFAULT NULL,
  `e_lname` varchar(20) DEFAULT NULL,
  `sub_message` varchar(400) DEFAULT NULL,
  `sub_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`e_id`, `e_fname`, `e_lname`, `sub_message`, `sub_date_time`) VALUES
(111, 'Atikan', 'Mangkala', 'Test message 1', '2023-10-24 15:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE `Order` (
  `o_id` char(10) NOT NULL,
  `o_date` date NOT NULL,
  `o_time` time NOT NULL,
  `total_amount` decimal(9,2) NOT NULL,
  `e_id` bigint(6) NOT NULL,
  `payment_id` bigint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Order`
--

INSERT INTO `Order` (`o_id`, `o_date`, `o_time`, `total_amount`, `e_id`, `payment_id`) VALUES
('3275482125', '2022-11-19', '18:25:50', '645.00', 111, 1),
('3346352116', '2023-10-17', '22:18:11', '280.00', 111, 1),
('3666602697', '2022-11-20', '12:58:08', '300.00', 333, 1),
('4023176440', '2023-10-10', '19:00:00', '110.00', 111, 1),
('4792278009', '2022-11-20', '23:09:10', '200.00', 111, 1),
('6363154731', '2022-11-19', '12:33:44', '250.00', 111, 1),
('7271765977', '2022-11-18', '18:43:32', '520.00', 111, 1),
('7336717011', '2022-11-20', '20:36:34', '640.00', 111, 1),
('8661536431', '2022-11-20', '18:31:28', '270.00', 111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `payment_id` bigint(6) NOT NULL,
  `payment_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`payment_id`, `payment_type`) VALUES
(1, 'Cash'),
(2, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(30) NOT NULL,
  `p_detail` varchar(50) DEFAULT NULL,
  `p_price` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`p_id`, `p_name`, `p_detail`, `p_price`) VALUES
(101, 'Apple Pie', NULL, '120.00'),
(102, 'Cheery Pie', NULL, '120.00'),
(103, 'Blueberry Cake', NULL, '80.00'),
(104, 'Chocolate Cake', 'Premium Chocolate from Switzerland', '100.00'),
(105, 'Lemon Cake', NULL, '120.00'),
(106, 'Cookie Cake', NULL, '100.00'),
(107, 'Waffle', NULL, '80.00'),
(108, 'Blueberry Mufin', 'Homemade by Atikan', '45.00'),
(109, 'Chocolate Mufin', 'Homemade by Atikan', '40.00'),
(110, 'Chocolate Cookie', NULL, '60.00'),
(111, 'Macaron', NULL, '50.00'),
(112, 'Oatmeal Cookie', NULL, '60.00'),
(113, 'Bagel', NULL, '50.00'),
(114, 'Croissant', NULL, '90.00'),
(115, 'Ham & Cheese', NULL, '65.00'),
(116, 'Toast', NULL, '80.00'),
(117, 'Sandwich', NULL, '50.00'),
(118, 'Pancake', NULL, '165.00'),
(201, 'Earl Grey', 'Product from India', '100.00'),
(202, 'Green Tea', NULL, '60.00'),
(203, 'Macha', 'Hokkaido Imported', '70.00'),
(204, 'Hot Americano', 'Madagascar Coffee Bean', '65.00'),
(205, 'Latte', NULL, '65.00'),
(206, 'Cappuccino', NULL, '60.00'),
(207, 'Hot Chocolate', NULL, '60.00'),
(208, 'Lemonade', NULL, '90.00'),
(210, 'Passion Fruit', '', '70.00'),
(211, 'Strawberry', NULL, '90.00'),
(212, 'Milk', 'Low Fat', '20.00'),
(12313123, 'Chock', '<h1>Hello</h1>', '500.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Detail_line`
--
ALTER TABLE `Detail_line`
  ADD PRIMARY KEY (`d_id`,`o_id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `o_id` (`o_id`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `e_id` (`e_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`p_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Detail_line`
--
ALTER TABLE `Detail_line`
  ADD CONSTRAINT `detail_line_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `Product` (`p_id`),
  ADD CONSTRAINT `detail_line_ibfk_2` FOREIGN KEY (`o_id`) REFERENCES `Order` (`o_id`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`e_id`) REFERENCES `Employee` (`e_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `Payment` (`payment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

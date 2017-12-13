-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2017 at 11:51 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minor_appsys_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `place` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_no`, `type`, `place`, `price`) VALUES
(4, 101, 'Junior Suite', 'occupied', 1000),
(5, 102, 'Junior Suite', 'occupied', 1000),
(6, 103, 'Junior Suite', 'occupied', 1000),
(7, 104, 'Junior Suite', 'vacant', 1000),
(8, 105, 'Standard Room', 'occupied', 1500),
(9, 106, 'Standard Room', 'vacant', 1500),
(10, 107, 'Standard Room', 'vacant', 1500),
(11, 108, 'Superior Room', 'vacant', 3000),
(16, 109, 'Superior Room', 'occupied', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `roombook`
--

CREATE TABLE `roombook` (
  `id` int(11) NOT NULL,
  `FName` text NOT NULL,
  `LName` text NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` text NOT NULL,
  `room_no` int(11) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `stat` varchar(40) NOT NULL,
  `pay_stat` varchar(40) NOT NULL,
  `nodays` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roombook`
--

INSERT INTO `roombook` (`id`, `FName`, `LName`, `Email`, `Phone`, `room_no`, `cin`, `cout`, `stat`, `pay_stat`, `nodays`) VALUES
(31, 'qwqeq', 'sfasf', 'fdsa@gmail', '099089098', 104, '2017-12-13', '2017-12-30', 'Not Confirm', 'Pending', 17),
(26, 'abenz', 'abenoja', 'abenoja@gmail.com', '098098123', 109, '2017-12-13', '2017-12-30', 'Confirmed', 'Pending', 17),
(27, 'war', 'warrak', 'war@gmail.com', '09809808', 105, '2017-12-13', '2017-12-29', 'Confirmed', 'Pending', 16),
(29, 'abenz', 'abenoja', 'abenz@gmail.com', '09091231441', 106, '2017-12-13', '2017-12-23', 'Confirmed', 'Pending', 10),
(30, 'admi', 'admi', 'admi@gmail.com', '00911231215', 106, '2017-12-13', '2017-12-15', 'Confirmed', 'Paid', 2),
(25, 'sdsd', 'asdadsdsdsdsdsdsd', '2344sasda@gmail.cc', '234', 104, '2017-12-13', '2017-12-21', 'Confirmed', 'Paid', 8),
(23, 'gomez', 'claveria', 'clav@gmail', '12321312', 109, '2017-12-14', '2017-12-28', 'Confirmed', 'Paid', 14),
(22, 'vergel', 'gomez', 'vergel@gmail.com', '09876543211', 106, '2017-12-14', '2017-12-29', 'Confirmed', 'Paid', 15),
(21, 'vergel', 'claveria', 'clav@gmail', '098087907', 105, '2017-12-14', '2017-12-23', 'Confirmed', 'Paid', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_type`, `user_status`) VALUES
(1, 'admin@gmail.com', '$2y$10$w8FFZ3cq23sCt2VR3DRsTeWCfwRPSfI2AH8rGWT5ZGN0f062RNRzW', 'admin', 'master', 'Active'),
(5, 'char@gmail.com', '$2y$10$g1IvHngucvpNluW8i9kw0uW9E3ZSyYD64P347tl9QxY7fPilOxvka', 'char', 'user', 'Inactive'),
(3, 'abenz@gmail.com', '$2y$10$zYttMF/jbGJ8bBuLBY0NfOMCA047L0bbV3Gcbe20n2A/oSml7QTzG', 'abenz', 'user', 'Active'),
(4, 'v@gmail', '$2y$10$KJwH50Pdl6NCBVwVIGc5Gef383hNPu/EfUkg4RpSrg5HRR/ukuDKW', 'vergel', 'user', 'Active'),
(8, 'awaw@gg.com', '$2y$10$8j2y58MOz4umuy1C6923Qu6QVs6ALnWlz.Hp28Kav1sIEwgREtO32', 'awaw', 'user', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_no` (`room_no`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

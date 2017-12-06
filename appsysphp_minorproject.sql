-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2017 at 11:26 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appsysphp_minorproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `hashed_password`, `role`) VALUES
(4, 'admin', '$2y$10$N2U1YjU2NDBiZDE1Y2NkMuttBaSAH0hRNmYwTV361ni1Ey1g7xwdW', 'Administrator'),
(5, 'boss', '$2y$10$YmQyY2FlMmZmNWZmZjBjMubxY9HKwKknbaaDzZqW4J/I48h/R02fy', 'Receptionist'),
(6, 'abenz', '$2y$10$MzQyNjNhMTYwYWEzMWMxN.0SX0ia1qqevgXRTIrR3Wk7P6jiPvFXy', 'Receptionist'),
(7, 'abenz', '$2y$10$NDVhMTkyZTAxOTBkYzZhYehI.Mf5a0gLuPMEvIb1C9Iv/j/ZGM8gW', 'Receptionist');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `res_id` int(11) NOT NULL,
  `date_in` date NOT NULL,
  `date_out` date NOT NULL,
  `made_by` varchar(20) NOT NULL,
  `guest_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(11) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `member_since` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hosted_at`
--

CREATE TABLE `hosted_at` (
  `id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `occupied_room_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `occupied_room`
--

CREATE TABLE `occupied_room` (
  `occupied_room_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` timestamp NOT NULL,
  `check_out` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserved_room`
--

CREATE TABLE `reserved_room` (
  `res_room_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `number_of_rooms` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` varchar(10) NOT NULL,
  `amount` double NOT NULL,
  `room_type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `room_type_id` int(11) NOT NULL,
  `description` varchar(80) NOT NULL,
  `max_capacity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
(1, 'abenz@gmail.com', '$2y$10$tl4SuH3sweOHvp6Sff7iIel5XsT26.aQRy4Z48HreiyGvCawFYaKG', 'abenz', 'master', 'Active'),
(2, 'boss@gmail.com', '$2y$10$evUtIOgsWyj2/CWKDsu/Ae0ylgODrD.YodKCfIChuhkmKuPveL82a', 'boss', 'user', 'Active'),
(7, 'lar@gmail.com', '$2y$10$kEOcHibJV82t3O.zxz8buuZgeKy8b9t/Hp6dJsnkEygMxgi0id/u2', 'lar', 'user', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `hosted_at`
--
ALTER TABLE `hosted_at`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `occupied_room_id` (`occupied_room_id`);

--
-- Indexes for table `occupied_room`
--
ALTER TABLE `occupied_room`
  ADD PRIMARY KEY (`occupied_room_id`),
  ADD KEY `res_id` (`res_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `reserved_room`
--
ALTER TABLE `reserved_room`
  ADD PRIMARY KEY (`res_room_id`),
  ADD KEY `res_id` (`res_id`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_type_id` (`room_type_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hosted_at`
--
ALTER TABLE `hosted_at`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `occupied_room`
--
ALTER TABLE `occupied_room`
  MODIFY `occupied_room_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reserved_room`
--
ALTER TABLE `reserved_room`
  MODIFY `res_room_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2017 at 07:47 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_share`
--

-- --------------------------------------------------------

--
-- Table structure for table `approved_jobs`
--

CREATE TABLE `approved_jobs` (
  `app_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `task_id` int(11) NOT NULL,
  `bidder_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approved_jobs`
--

INSERT INTO `approved_jobs` (`app_id`, `approved`, `task_id`, `bidder_id`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `DIS_ID` int(11) NOT NULL,
  `DISTRICT` varchar(20) NOT NULL,
  `COUNTRY` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`DIS_ID`, `DISTRICT`, `COUNTRY`) VALUES
(1, 'Sylhet', 'Bangladesh'),
(2, 'Sunamganj', 'Bangladesh'),
(3, 'Hobiganj', 'Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `EMPLOYER_ID` int(11) NOT NULL,
  `LATTITUDE` double(12,10) NOT NULL,
  `LONGITUDE` double(12,10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LOC_ID` int(11) NOT NULL,
  `LATTITUDE` double(12,10) NOT NULL,
  `LONGITUDE` double(12,10) NOT NULL,
  `DIS_ID` int(11) NOT NULL,
  `REGION` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LOC_ID`, `LATTITUDE`, `LONGITUDE`, `DIS_ID`, `REGION`) VALUES
(1, 24.9066490000, 91.8442080000, 1, 'Neharipara'),
(2, 24.9065490000, 91.8442080000, 1, 'Ansar Camp'),
(3, 24.9164490000, 91.8242180000, 1, 'Akhalia,L shape');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(20) NOT NULL,
  `skill_name` varchar(20) NOT NULL,
  `describe_task` varchar(250) NOT NULL,
  `delivery_address` varchar(50) NOT NULL,
  `task_deadline` datetime NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `currency_unit` varchar(10) NOT NULL,
  `budget` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `skill_name`, `describe_task`, `delivery_address`, `task_deadline`, `USER_ID`, `currency_unit`, `budget`) VALUES
(1, 'Laptop delivery', 'any person', 'A hp laptop 450 g2 (50,000/=) from korim ullah market, bondor', 'Neharipara', '2017-09-15 12:00:00', 1, 'TAKA', 150),
(2, 'Book delivery', 'Student, sust', 'a architechture book from maloncho library, zindabazar', 'Akhalia,L Shape', '2017-09-16 13:00:00', 2, 'TAKA', 50),
(3, 'Food delivery', 'any person', 'A half grill from Paprika resturant, Keen bridge entrance right side', 'Ansar Camp', '2017-09-16 20:00:00', 3, 'TAKA', 40),
(4, 'Book delivery', 'Student, sust', 'A computer graphics book from maloncho library,zindabazar', 'Neharipara', '2017-09-18 13:00:00', 4, 'TAKA', 30),
(5, 'm', 'm', 'm', 'Ansar Camp', '2017-12-02 12:59:00', 1, 'TAKA', 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` varchar(30) NOT NULL,
  `EMAIL` varchar(20) NOT NULL,
  `NID_NUMBER` int(11) NOT NULL,
  `DISTRICT` varchar(20) NOT NULL,
  `PASSWORD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_NAME`, `EMAIL`, `NID_NUMBER`, `DISTRICT`, `PASSWORD`) VALUES
(1, 'Mehadi_49', 'mehadi541@gmail.com', 49, 'Sylhet', 1212),
(2, 'Tanmoy_41', 'tanmoy41@gmail.com', 41, 'Sylhet', 1212),
(3, 'Nazmul_34', 'nazmul34@gmail.com', 34, 'Sunamganj', 1212),
(4, 'Rezaul_44', 'rezaul44@gmail.com', 44, 'Sunamganj', 1212);

-- --------------------------------------------------------

--
-- Table structure for table `want_to_work`
--

CREATE TABLE `want_to_work` (
  `want_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `want_to_work`
--

INSERT INTO `want_to_work` (`want_id`, `task_id`, `user_id`) VALUES
(2, 1, 3),
(5, 1, 4),
(4, 2, 1),
(1, 2, 3),
(3, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approved_jobs`
--
ALTER TABLE `approved_jobs`
  ADD PRIMARY KEY (`app_id`),
  ADD UNIQUE KEY `task_id` (`task_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`DIS_ID`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD UNIQUE KEY `LATTITUDE` (`LATTITUDE`,`LONGITUDE`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LOC_ID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`,`describe_task`,`delivery_address`,`task_deadline`,`USER_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `NID_NUMBER` (`NID_NUMBER`);

--
-- Indexes for table `want_to_work`
--
ALTER TABLE `want_to_work`
  ADD PRIMARY KEY (`want_id`),
  ADD UNIQUE KEY `task_id` (`task_id`,`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approved_jobs`
--
ALTER TABLE `approved_jobs`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `DIS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LOC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `want_to_work`
--
ALTER TABLE `want_to_work`
  MODIFY `want_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2017 at 07:43 PM
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
-- Database: `jamat_time`
--

-- --------------------------------------------------------

--
-- Table structure for table `commenttable`
--

CREATE TABLE `commenttable` (
  `comment_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commenttable`
--

INSERT INTO `commenttable` (`comment_id`, `name`, `comment`) VALUES
(1, 'Mehadi', 'First comment for checking!!!'),
(2, 'Mehadi', 'Second comment!!!');

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
(3, 'Hobiganj', 'Bangladesh'),
(6, 'Hydrabad', 'India'),
(5, 'Kalkata', 'India'),
(4, 'New Delhi', 'India'),
(2, 'Sunamganj', 'Bangladesh'),
(1, 'Sylhet', 'Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `jamat_time`
--

CREATE TABLE `jamat_time` (
  `JAMAT_TIME_ID` int(11) NOT NULL,
  `DIS_ID` int(11) NOT NULL,
  `MASJID_ID` int(11) NOT NULL,
  `MASJID_NAME` varchar(255) NOT NULL,
  `DATE` date NOT NULL,
  `FAJR` varchar(255) NOT NULL,
  `DHUHR` varchar(255) NOT NULL,
  `ASR` varchar(255) NOT NULL,
  `MAGRIB` varchar(255) NOT NULL,
  `ISHA` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `masjid`
--

CREATE TABLE `masjid` (
  `MASJID_ID` int(11) NOT NULL,
  `DIS_ID` int(11) NOT NULL,
  `MASJID_NAME` varchar(255) NOT NULL,
  `LATITUDE` double(12,10) NOT NULL,
  `LONGITUDE` double(12,10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masjid`
--

INSERT INTO `masjid` (`MASJID_ID`, `DIS_ID`, `MASJID_NAME`, `LATITUDE`, `LONGITUDE`) VALUES
(1, 1, 'Ansar Camp Jame Masjid', 24.9101780000, 91.5735340000);

-- --------------------------------------------------------

--
-- Table structure for table `salat_time`
--

CREATE TABLE `salat_time` (
  `ID` int(11) NOT NULL,
  `DIS_ID` int(11) NOT NULL,
  `MONTH` varchar(10) NOT NULL,
  `DAY` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `FAJR` varchar(10) NOT NULL,
  `SUNRISE` varchar(10) NOT NULL,
  `DHUHR` varchar(10) NOT NULL,
  `ASR` varchar(10) NOT NULL,
  `MAGRIB` varchar(10) NOT NULL,
  `ISHA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_jamat_time`
--

CREATE TABLE `temp_jamat_time` (
  `TEMP_JAMAT_TIME_ID` int(11) NOT NULL,
  `DIS_ID` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `MASJID_ID` int(11) NOT NULL,
  `MASJID_NAME` varchar(200) NOT NULL,
  `FAJR` varchar(255) NOT NULL,
  `DHUHR` varchar(255) NOT NULL,
  `ASR` varchar(255) NOT NULL,
  `MAGRIB` varchar(255) NOT NULL,
  `ISHA` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_jamat_time`
--

INSERT INTO `temp_jamat_time` (`TEMP_JAMAT_TIME_ID`, `DIS_ID`, `DATE`, `MASJID_ID`, `MASJID_NAME`, `FAJR`, `DHUHR`, `ASR`, `MAGRIB`, `ISHA`) VALUES
(1, 0, '2017-09-16', 1, 'Ansar Camp Jame Masjid', '05:05:00', '13:15:00', '17:05:00', '18:10:00', '20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `USER_NAME` varchar(30) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `MASJID_NAME` varchar(50) NOT NULL,
  `DISTRICT` varchar(20) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_NAME`, `EMAIL`, `MASJID_NAME`, `DISTRICT`, `PASSWORD`) VALUES
(1, 'Mehadi_49', 'mehadi541@gmail.com', 'Ansar Camp Jame Masjid', 'Sylhet', '1212');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commenttable`
--
ALTER TABLE `commenttable`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`DIS_ID`),
  ADD UNIQUE KEY `DISTRICT` (`DISTRICT`,`COUNTRY`);

--
-- Indexes for table `jamat_time`
--
ALTER TABLE `jamat_time`
  ADD PRIMARY KEY (`JAMAT_TIME_ID`);

--
-- Indexes for table `masjid`
--
ALTER TABLE `masjid`
  ADD PRIMARY KEY (`MASJID_ID`),
  ADD UNIQUE KEY `DIS_ID` (`DIS_ID`,`MASJID_NAME`,`LONGITUDE`);

--
-- Indexes for table `salat_time`
--
ALTER TABLE `salat_time`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `DIS_ID` (`DIS_ID`,`MONTH`,`DAY`);

--
-- Indexes for table `temp_jamat_time`
--
ALTER TABLE `temp_jamat_time`
  ADD PRIMARY KEY (`TEMP_JAMAT_TIME_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commenttable`
--
ALTER TABLE `commenttable`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `DIS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jamat_time`
--
ALTER TABLE `jamat_time`
  MODIFY `JAMAT_TIME_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `masjid`
--
ALTER TABLE `masjid`
  MODIFY `MASJID_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `salat_time`
--
ALTER TABLE `salat_time`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;
--
-- AUTO_INCREMENT for table `temp_jamat_time`
--
ALTER TABLE `temp_jamat_time`
  MODIFY `TEMP_JAMAT_TIME_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

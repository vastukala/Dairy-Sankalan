-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 07:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dairy_sanklan`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_detail`
--

CREATE TABLE `company_detail` (
  `srno` int(11) NOT NULL,
  `comname` varchar(255) DEFAULT NULL,
  `smstext` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `yearstart` datetime DEFAULT NULL,
  `yearend` datetime DEFAULT NULL,
  `thev` decimal(18,2) DEFAULT NULL,
  `paper` decimal(18,2) DEFAULT NULL,
  `otherrate` decimal(18,2) DEFAULT NULL,
  `working` decimal(18,2) DEFAULT NULL,
  `otherribit` decimal(18,2) DEFAULT NULL,
  `bufribt` decimal(18,2) DEFAULT NULL,
  `cowribt` decimal(18,2) DEFAULT NULL,
  `fat` text DEFAULT NULL,
  `buf_commision` decimal(18,2) DEFAULT NULL,
  `cow_commision` decimal(18,2) DEFAULT NULL,
  `print_By` varchar(50) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `sms_status` varchar(50) DEFAULT NULL,
  `owner_name` text DEFAULT NULL,
  `owner_bank_acno` bigint(20) DEFAULT NULL,
  `webservice` varchar(50) DEFAULT NULL,
  `ProcessBy` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_detail`
--

INSERT INTO `company_detail` (`srno`, `comname`, `smstext`, `city`, `path`, `username`, `password`, `yearstart`, `yearend`, `thev`, `paper`, `otherrate`, `working`, `otherribit`, `bufribt`, `cowribt`, `fat`, `buf_commision`, `cow_commision`, `print_By`, `active`, `sms_status`, `owner_name`, `owner_bank_acno`, `webservice`, `ProcessBy`) VALUES
(1, 'Warana Dairy', 'ddsdsdds', 'kolhapur', 'fgfgf', 'Pratiksha', 'pass123', '2002-02-04 00:00:00', '2025-12-03 00:00:00', 5.60, 7.40, 8.60, 9.60, 9.50, 5.40, 2.30, '11', 2.30, 3.30, '4rfd', 'A', 'fdfdfd', 'gdffgdgffg', 45433453323466, 'gfgfdfd', 'fdfdfdeweew'),
(2, 'Gokul Dairy', 'dfdd', 'kolhapur', 'dssd', 'Radha', 'pass123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `milk_sanklan1`
--

CREATE TABLE `milk_sanklan1` (
  `entryno` int(11) NOT NULL,
  `sandate` datetime DEFAULT NULL,
  `accno` bigint(20) DEFAULT NULL,
  `acname` text DEFAULT NULL,
  `morning` varchar(50) DEFAULT NULL,
  `evening` varchar(50) DEFAULT NULL,
  `bufliter` decimal(18,3) DEFAULT NULL,
  `cowliter` decimal(18,3) DEFAULT NULL,
  `fat` decimal(18,1) DEFAULT NULL,
  `snf` decimal(18,1) DEFAULT NULL,
  `rate` decimal(18,2) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `degree` decimal(18,1) DEFAULT NULL,
  `morningflag` varchar(50) DEFAULT NULL,
  `eviningflag` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `milk_sanklan1`
--

INSERT INTO `milk_sanklan1` (`entryno`, `sandate`, `accno`, `acname`, `morning`, `evening`, `bufliter`, `cowliter`, `fat`, `snf`, `rate`, `amount`, `degree`, `morningflag`, `eviningflag`) VALUES
(2, '2025-06-13 00:00:00', 101, 'Pratiksha', 'M', NULL, 2.000, NULL, 1.0, 34.0, NULL, NULL, NULL, NULL, NULL),
(3, '2025-06-06 00:00:00', 89, 'Radha', 'M', NULL, NULL, 54.700, 67.7, 56.8, NULL, NULL, NULL, NULL, NULL),
(4, '2025-06-14 00:00:00', 102, 'Suresh', 'M', NULL, 3.000, 40.500, 2.0, 30.0, NULL, NULL, NULL, NULL, NULL),
(5, '2025-06-14 00:00:00', 103, 'Ramesh', 'M', NULL, NULL, 45.700, 2.5, 32.5, NULL, NULL, NULL, NULL, NULL),
(6, '2025-06-14 00:00:00', 104, 'Geeta', 'M', NULL, 1.000, NULL, 1.2, 33.0, NULL, NULL, NULL, NULL, NULL),
(7, '2025-06-15 00:00:00', 105, 'Nita', 'M', NULL, 2.200, 48.300, 2.3, 31.0, NULL, NULL, NULL, NULL, NULL),
(8, '2025-06-15 00:00:00', 106, 'Sunil', 'M', NULL, NULL, NULL, 1.8, 35.5, NULL, NULL, NULL, NULL, NULL),
(9, '2025-06-15 00:00:00', 107, 'Lata', 'M', NULL, 2.000, 49.000, 2.2, 32.0, NULL, NULL, NULL, NULL, NULL),
(10, '2025-06-16 00:00:00', 108, 'Vikas', 'M', NULL, 1.500, 43.500, 1.9, 33.2, NULL, NULL, NULL, NULL, NULL),
(11, '2025-06-16 00:00:00', 109, 'Meena', 'M', NULL, 2.100, 46.700, 2.0, 31.9, NULL, NULL, NULL, NULL, NULL),
(12, '2025-06-16 00:00:00', 110, 'Amit', 'M', NULL, NULL, 42.000, 2.1, 34.0, NULL, NULL, NULL, NULL, NULL),
(13, '2025-06-17 00:00:00', 111, 'Rekha', 'M', NULL, 2.300, 50.100, 2.4, 30.5, NULL, NULL, NULL, NULL, NULL),
(16, '2025-06-18 00:00:00', 102, 'Suresh', 'M', NULL, 5.000, NULL, 2.0, 6.5, NULL, NULL, NULL, NULL, NULL),
(17, '2025-06-18 00:00:00', 104, 'Geeta', 'M', NULL, 5.000, NULL, 5.5, 5.6, NULL, NULL, NULL, NULL, NULL),
(18, '2025-06-18 00:00:00', 109, 'Meena', NULL, 'E', NULL, 8.000, 5.0, 4.0, NULL, NULL, NULL, NULL, NULL),
(19, '2025-06-23 00:00:00', 102, 'Suresh', 'M', NULL, 5.000, NULL, 5.6, 4.0, NULL, NULL, NULL, NULL, NULL),
(20, '2025-06-23 00:00:00', 109, 'Meena', 'M', NULL, NULL, 4.000, 5.0, 6.0, NULL, NULL, NULL, NULL, NULL),
(21, '2025-06-23 00:00:00', 105, 'Nita', 'M', NULL, NULL, 5.000, 6.0, 5.0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sabasad_master`
--

CREATE TABLE `sabasad_master` (
  `sno` int(11) NOT NULL,
  `accno` bigint(20) DEFAULT NULL,
  `sname` text DEFAULT NULL,
  `sname_eng` text DEFAULT NULL,
  `sphone` bigint(20) DEFAULT NULL,
  `spass` text DEFAULT NULL,
  `sgroup` text DEFAULT NULL,
  `fatrate` text DEFAULT NULL,
  `billtype` text DEFAULT NULL,
  `bankname` text DEFAULT NULL,
  `bnkaccno` text DEFAULT NULL,
  `bankrokha` text DEFAULT NULL,
  `bufalo` varchar(50) DEFAULT NULL,
  `cow` varchar(50) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `panno` text DEFAULT NULL,
  `adharno` bigint(20) DEFAULT NULL,
  `dispatchcomp` text DEFAULT NULL,
  `deposit` decimal(18,2) DEFAULT NULL,
  `transport` decimal(18,2) DEFAULT NULL,
  `allowance` decimal(18,2) DEFAULT NULL,
  `allowanceC` decimal(18,2) DEFAULT NULL,
  `sms_status` varchar(50) DEFAULT NULL,
  `bonusB` decimal(18,2) DEFAULT NULL,
  `bonusC` decimal(18,2) DEFAULT NULL,
  `billDays` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sabasad_master`
--

INSERT INTO `sabasad_master` (`sno`, `accno`, `sname`, `sname_eng`, `sphone`, `spass`, `sgroup`, `fatrate`, `billtype`, `bankname`, `bnkaccno`, `bankrokha`, `bufalo`, `cow`, `active`, `panno`, `adharno`, `dispatchcomp`, `deposit`, `transport`, `allowance`, `allowanceC`, `sms_status`, `bonusB`, `bonusC`, `billDays`) VALUES
(2, 101, 'Pratiksha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 89, 'Radha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 102, 'Suresh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 103, 'Ramesh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 104, 'Geeta', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 105, 'Nita', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 106, 'Sunil', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 107, 'Lata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 108, 'Vikas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 109, 'Meena', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 110, 'Amit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 111, 'Rekha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_detail`
--
ALTER TABLE `company_detail`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `milk_sanklan1`
--
ALTER TABLE `milk_sanklan1`
  ADD PRIMARY KEY (`entryno`);

--
-- Indexes for table `sabasad_master`
--
ALTER TABLE `sabasad_master`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_detail`
--
ALTER TABLE `company_detail`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milk_sanklan1`
--
ALTER TABLE `milk_sanklan1`
  MODIFY `entryno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sabasad_master`
--
ALTER TABLE `sabasad_master`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

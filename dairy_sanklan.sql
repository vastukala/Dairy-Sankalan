-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 11:11 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `smstext` text,
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
  `fat` text,
  `buf_commision` decimal(18,2) DEFAULT NULL,
  `cow_commision` decimal(18,2) DEFAULT NULL,
  `print_By` varchar(50) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `sms_status` varchar(50) DEFAULT NULL,
  `owner_name` text,
  `owner_bank_acno` bigint(20) DEFAULT NULL,
  `webservice` varchar(50) DEFAULT NULL,
  `ProcessBy` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_detail`
--

INSERT INTO `company_detail` (`srno`, `comname`, `smstext`, `city`, `path`, `username`, `password`, `yearstart`, `yearend`, `thev`, `paper`, `otherrate`, `working`, `otherribit`, `bufribt`, `cowribt`, `fat`, `buf_commision`, `cow_commision`, `print_By`, `active`, `sms_status`, `owner_name`, `owner_bank_acno`, `webservice`, `ProcessBy`) VALUES
(1, 'Warana Dairy', 'ddsdsdds', 'kolhapur', 'fgfgf', 'Pratiksha', 'pass123', '2002-02-04 00:00:00', '2025-12-03 00:00:00', '5.60', '7.40', '8.60', '9.60', '9.50', '5.40', '2.30', '11', '2.30', '3.30', '4rfd', 'A', 'fdfdfd', 'gdffgdgffg', 45433453323466, 'gfgfdfd', 'fdfdfdeweew'),
(2, 'Gokul Dairy', 'dfdd', 'kolhapur', 'dssd', 'Radha', 'pass123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `milk_sanklan1`
--

CREATE TABLE `milk_sanklan1` (
  `entryno` int(11) NOT NULL,
  `sandate` datetime DEFAULT NULL,
  `accno` bigint(20) DEFAULT NULL,
  `acname` text,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_sanklan1`
--

INSERT INTO `milk_sanklan1` (`entryno`, `sandate`, `accno`, `acname`, `morning`, `evening`, `bufliter`, `cowliter`, `fat`, `snf`, `rate`, `amount`, `degree`, `morningflag`, `eviningflag`) VALUES
(2, '2025-06-13 00:00:00', 101, 'Pratiksha', 'M', NULL, '2.000', NULL, '1.0', '34.0', NULL, NULL, NULL, NULL, NULL),
(3, '2025-06-06 00:00:00', 89, 'Radha', 'M', NULL, NULL, '54.700', '67.7', '56.8', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sabasad_master`
--

CREATE TABLE `sabasad_master` (
  `sno` int(11) NOT NULL,
  `accno` bigint(20) DEFAULT NULL,
  `sname` text,
  `sname_eng` text,
  `sphone` bigint(20) DEFAULT NULL,
  `spass` text,
  `sgroup` text,
  `fatrate` text,
  `billtype` text,
  `bankname` text,
  `bnkaccno` text,
  `bankrokha` text,
  `bufalo` varchar(50) DEFAULT NULL,
  `cow` varchar(50) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `panno` text,
  `adharno` bigint(20) DEFAULT NULL,
  `dispatchcomp` text,
  `deposit` decimal(18,2) DEFAULT NULL,
  `transport` decimal(18,2) DEFAULT NULL,
  `allowance` decimal(18,2) DEFAULT NULL,
  `allowanceC` decimal(18,2) DEFAULT NULL,
  `sms_status` varchar(50) DEFAULT NULL,
  `bonusB` decimal(18,2) DEFAULT NULL,
  `bonusC` decimal(18,2) DEFAULT NULL,
  `billDays` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sabasad_master`
--

INSERT INTO `sabasad_master` (`sno`, `accno`, `sname`, `sname_eng`, `sphone`, `spass`, `sgroup`, `fatrate`, `billtype`, `bankname`, `bnkaccno`, `bankrokha`, `bufalo`, `cow`, `active`, `panno`, `adharno`, `dispatchcomp`, `deposit`, `transport`, `allowance`, `allowanceC`, `sms_status`, `bonusB`, `bonusC`, `billDays`) VALUES
(2, 101, 'Pratiksha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 89, 'Radha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  ADD PRIMARY KEY (`entryno`),
  ADD UNIQUE KEY `accno` (`accno`);

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
  MODIFY `entryno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sabasad_master`
--
ALTER TABLE `sabasad_master`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

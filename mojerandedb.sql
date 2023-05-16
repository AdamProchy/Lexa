-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 08:24 AM
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
-- Database: `mojerandedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `ID` int(11) NOT NULL,
  `firstName` varchar(80) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `gender` varchar(3) NOT NULL COMMENT 'M(ale)\r\nF(emale)\r\nMtF (Trans female)\r\nFtM (Trans male)',
  `sexuality` varchar(1) NOT NULL COMMENT 'S(traight)\r\nG(ay)\r\nL(esbian)\r\nB(isexual)\r\nA(sexual)\r\nD(emisexual)\r\nP(ansexual)\r\nQ(ueer)\r\n?(Questioning)',
  `birthDate` date DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `psw` char(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Registration date (automatic)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`ID`, `firstName`, `lastName`, `gender`, `sexuality`, `birthDate`, `email`, `psw`, `reg_date`) VALUES
(1, 'Admin', 'Admin', 'M', 'S', '2004-11-13', 'admin@admin.com', '$2y$10$bJxEGMf4NsVaU9fP1RR5C.M/O55Dl3dzsjQpw0caKATKAWUPb4776', '2023-04-26 16:47:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

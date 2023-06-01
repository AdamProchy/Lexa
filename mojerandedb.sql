-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 06:02 PM
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
  `birthDate` date NOT NULL,
  `email` varchar(80) NOT NULL,
  `psw` char(255) NOT NULL,
  `profilePicture` varchar(100) NOT NULL DEFAULT 'default.png',
  `aboutMe` varchar(100) DEFAULT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Registration date (automatic)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`ID`, `firstName`, `lastName`, `gender`, `sexuality`, `birthDate`, `email`, `psw`, `profilePicture`, `aboutMe`, `reg_date`) VALUES
(1, 'Admin', 'Admin', 'M', 'S', '2004-11-13', 'admin@admin.com', '$2y$10$bJxEGMf4NsVaU9fP1RR5C.M/O55Dl3dzsjQpw0caKATKAWUPb4776', '646f244e6f9f6.png', NULL, '2023-04-26 16:47:53'),
(16, 'Matyáš', 'Závora', 'M', 'S', '2004-11-13', 'matyaszavora@outlook.com', '$2y$10$0WGJwGBkJNaMLdWSpy6YrObHTfK.9wO35Nnrb3m9h6vD8NMRM4X06', '6476f92b0cd8e.png', '0338471751481638655214972767799865764327158409418558460276033209280157148388857633936772339926572984', '2023-05-24 08:44:02'),
(19, 'Lexa', 'Bůček', 'M', 'S', '1984-07-26', 'leksa@seznam.cz', '$2y$10$lpelvmgnxlpXpAMrvAzYs.rcN9TA/5JTaTaUe0Zl0aafMaJZqu8gi', '646f2590577c1.jpg', NULL, '2023-05-25 11:00:41'),
(20, 'Ozzák', 'Pacovský', 'M', 'S', '1984-02-14', 'ozzak@seznam.cz', '$2y$10$jKSpmU4SMXiUXwj/8qTes.F47PZANxQHolNGun0YBZrfBwjeZTjuK', '646f26025991e.png', NULL, '2023-05-25 11:09:41'),
(21, 'Tomáš ', 'Pacovský', 'M', 'S', '1962-12-07', 'tomipaci@centrum.cz', '$2y$10$jLgDcjpRfX2WjZERQiIQweEROmW1NhLu2pAOY9BP4MSIGAw2znueK', '646f27341befb.png', NULL, '2023-05-25 11:13:27'),
(22, 'Iva', 'Pacovská', 'F', 'S', '1999-03-07', 'ivuska@gmail.com', '$2y$10$qkYYa3owFSqF38uOrGDGT.idV.leQj47Bi6mlnMstcrcNfPqvjvJC', '646f27d0f2854.png', NULL, '2023-05-25 11:17:18'),
(23, 'Saša', 'Bůčková', 'F', 'S', '1984-05-09', 'sasa@seznam.cz', '$2y$10$D/pgCANQUat1qXop0uNl9uY/djyjX2nmGd.JjnGXCECBuaN0YpPSS', '646f286525551.png', NULL, '2023-05-25 11:19:59'),
(24, 'Marcelka', 'Divićová', 'F', 'S', '1984-04-07', 'marcelka@centrum.cz', '$2y$10$G6FG2Q.DhRoDq.YpXQ9JYuTggzWZyPnCsljno1K2ddchSLMbnKmEi', '646f28c44170d.png', NULL, '2023-05-25 11:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `ID` int(11) NOT NULL,
  `senderEmail` varchar(80) NOT NULL COMMENT 'Email of the person that sends invitation',
  `recipientEmail` varchar(80) NOT NULL COMMENT 'Email of the person that receives invitation',
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Date of creating an invitation',
  `dateInvitation` datetime NOT NULL COMMENT 'Date stated in the invitation',
  `message` varchar(150) DEFAULT NULL COMMENT 'A message from sender',
  `place` varchar(150) NOT NULL COMMENT 'Place from the invitation',
  `confirmed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

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
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

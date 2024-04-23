-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2024 at 09:08 PM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `mojerandedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms`
(
    `ID`           int NOT NULL,
    `user1_id`     int NOT NULL,
    `user2_id`     int NOT NULL,
    `last_message` datetime DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials`
(
    `ID`             int                                                         NOT NULL,
    `firstName`      varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `lastName`       varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `gender`         varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci   NOT NULL COMMENT 'M(ale)\r\nF(emale)\r\nMtF (Trans female)\r\nFtM (Trans male)',
    `sexuality`      varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci   NOT NULL COMMENT 'S(traight)\r\nG(ay)\r\nL(esbian)\r\nB(isexual)\r\nA(sexual)\r\nD(emisexual)\r\nP(ansexual)\r\nQ(ueer)\r\n?(Questioning)',
    `birthDate`      date                                                        NOT NULL,
    `email`          varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `psw`            char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci    NOT NULL,
    `profilePicture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'default.png',
    `aboutMe`        varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci          DEFAULT NULL,
    `reg_date`       datetime                                                    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `coins`          int                                                         NOT NULL DEFAULT '100'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`ID`, `firstName`, `lastName`, `gender`, `sexuality`, `birthDate`, `email`, `psw`, `aboutMe`,
                           `reg_date`, `coins`)
VALUES (1, 'Admin', 'Admin', 'M', 'S', '2004-11-13', 'admin@admin.com',
        '$2y$10$bJxEGMf4NsVaU9fP1RR5C.M/O55Dl3dzsjQpw0caKATKAWUPb4776', NULL,
        '2023-04-26 16:47:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates`
(
    `ID`             int                                                         NOT NULL,
    `senderId`       int                                                         NOT NULL,
    `recipientId`    int                                                         NOT NULL,
    `dateCreated`    datetime                                                    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of creating an invitation',
    `dateInvitation` datetime                                                    NOT NULL COMMENT 'Date stated in the invitation',
    `message`        varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci          DEFAULT NULL COMMENT 'A message from sender',
    `place`          varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Place from the invitation',
    `confirmed`      tinyint(1)                                                           DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages`
(
    `ID`          int                                                 NOT NULL,
    `sender_id`   int                                                 NOT NULL,
    `receiver_id` int                                                 NOT NULL,
    `message`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
    `created_at`  timestamp                                           NULL     DEFAULT CURRENT_TIMESTAMP,
    `new`         bit(1)                                              NOT NULL DEFAULT b'1'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_requests`
--

CREATE TABLE `money_requests`
(
    `ID`             int      NOT NULL,
    `applicantId`    int      NOT NULL,
    `issueDate`      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `amount`         int      NOT NULL,
    `accepted`       tinyint(1)        DEFAULT NULL,
    `verdictBy`      int               DEFAULT NULL,
    `verdictDate`    datetime          DEFAULT NULL,
    `variableSymbol` bigint            DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_messages`
--

CREATE TABLE `room_messages`
(
    `ID`         int NOT NULL,
    `room_id`    int NOT NULL,
    `message_id` int NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
    ADD PRIMARY KEY (`ID`),
    ADD KEY `user1_id` (`user1_id`),
    ADD KEY `user2_id` (`user2_id`);

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
    ADD PRIMARY KEY (`ID`),
    ADD KEY `dates_credentials_ID_fk` (`senderId`),
    ADD KEY `dates_credentials_ID_fk_2` (`recipientId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
    ADD PRIMARY KEY (`ID`),
    ADD KEY `sender_id` (`sender_id`),
    ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `money_requests`
--
ALTER TABLE `money_requests`
    ADD PRIMARY KEY (`ID`),
    ADD KEY `money_requests_credentials_ID_fk` (`applicantId`),
    ADD KEY `money_requests_credentials_ID_fk2` (`verdictBy`);

--
-- Indexes for table `room_messages`
--
ALTER TABLE `room_messages`
    ADD PRIMARY KEY (`ID`),
    ADD KEY `room_id` (`room_id`),
    ADD KEY `message_id` (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT for table `money_requests`
--
ALTER TABLE `money_requests`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

--
-- AUTO_INCREMENT for table `room_messages`
--
ALTER TABLE `room_messages`
    MODIFY `ID` int NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
    ADD CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dates`
--
ALTER TABLE `dates`
    ADD CONSTRAINT `dates_credentials_ID_fk` FOREIGN KEY (`senderId`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `dates_credentials_ID_fk_2` FOREIGN KEY (`recipientId`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
    ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `money_requests`
--
ALTER TABLE `money_requests`
    ADD CONSTRAINT `money_requests_credentials_ID_fk` FOREIGN KEY (`applicantId`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `money_requests_credentials_ID_fk2` FOREIGN KEY (`verdictBy`) REFERENCES `credentials` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room_messages`
--
ALTER TABLE `room_messages`
    ADD CONSTRAINT `room_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `room_messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
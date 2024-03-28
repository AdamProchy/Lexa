-- Adminer 4.8.1 MySQL 8.0.36-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `mojerandedb`;
CREATE DATABASE `mojerandedb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION = 'N' */;
USE `mojerandedb`;

DROP TABLE IF EXISTS `chat_rooms`;
CREATE TABLE `chat_rooms`
(
    `ID`           int NOT NULL AUTO_INCREMENT,
    `user1_id`     int NOT NULL,
    `user2_id`     int NOT NULL,
    `last_message` datetime DEFAULT NULL,
    PRIMARY KEY (`ID`),
    KEY `user1_id` (`user1_id`),
    KEY `user2_id` (`user2_id`),
    CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `credentials` (`ID`),
    CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `credentials` (`ID`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 13
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

TRUNCATE `chat_rooms`;
INSERT INTO `chat_rooms` (`ID`, `user1_id`, `user2_id`, `last_message`)
VALUES (5, 2, 4, '2024-03-28 17:52:18'),
       (6, 13, 2, '2024-03-27 11:58:58'),
       (12, 2, 11, NULL);

DROP TABLE IF EXISTS `credentials`;
CREATE TABLE `credentials`
(
    `ID`             int                                                         NOT NULL AUTO_INCREMENT,
    `firstName`      varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `lastName`       varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `gender`         varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci   NOT NULL COMMENT 'M(ale)\r\nF(emale)\r\nMtF (Trans female)\r\nFtM (Trans male)',
    `sexuality`      varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci   NOT NULL COMMENT 'S(traight)\r\nG(ay)\r\nL(esbian)\r\nB(isexual)\r\nA(sexual)\r\nD(emisexual)\r\nP(ansexual)\r\nQ(ueer)\r\n?(Questioning)',
    `birthDate`      date                                                        NOT NULL,
    `email`          varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci  NOT NULL,
    `psw`            char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci    NOT NULL,
    `profilePicture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'default.png',
    `aboutMe`        varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci          DEFAULT NULL,
    `reg_date`       datetime                                                    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration date (automatic)',
    PRIMARY KEY (`ID`),
    UNIQUE KEY `email` (`email`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 40
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

TRUNCATE `credentials`;
INSERT INTO `credentials` (`ID`, `firstName`, `lastName`, `gender`, `sexuality`, `birthDate`, `email`, `psw`,
                           `profilePicture`, `aboutMe`, `reg_date`)
VALUES (1, 'Admin', 'Admin', 'M', 'S', '2004-11-13', 'admin@admin.com',
        '$2y$10$bJxEGMf4NsVaU9fP1RR5C.M/O55Dl3dzsjQpw0caKATKAWUPb4776', '646f244e6f9f6.png', NULL,
        '2023-04-26 16:47:53'),
       (2, 'Matyáš', 'Závora', 'M', 'S', '2004-11-13', 'matyaszavora@outlook.com',
        '$2y$10$1Q.Fm4aMz.QWz2QSv58pW.tQgfGeY1DYR9E.ZP8cEI1FncOJ1UKZS', '6476f92b0cd8e.png', 'Sem frajer 💪',
        '2023-05-24 08:44:02'),
       (3, 'Lexa', 'Bůček', 'M', 'S', '1984-07-26', 'leksa@seznam.cz',
        '$2y$10$lpelvmgnxlpXpAMrvAzYs.rcN9TA/5JTaTaUe0Zl0aafMaJZqu8gi', '646f2590577c1.jpg', 'kys',
        '2023-05-25 11:00:41'),
       (4, 'Ozzák', 'Pacovský', 'M', 'S', '1984-02-14', 'ozzak@seznam.cz',
        '$2y$10$jKSpmU4SMXiUXwj/8qTes.F47PZANxQHolNGun0YBZrfBwjeZTjuK', '646f26025991e.png', NULL,
        '2023-05-25 11:09:41'),
       (5, 'Tomáš ', 'Pacovský', 'M', 'S', '1962-12-07', 'tomipaci@centrum.cz',
        '$2y$10$jLgDcjpRfX2WjZERQiIQweEROmW1NhLu2pAOY9BP4MSIGAw2znueK', '646f27341befb.png', NULL,
        '2023-05-25 11:13:27'),
       (6, 'Iva', 'Pacovská', 'F', 'S', '1999-03-07', 'ivuska@gmail.com',
        '$2y$10$qkYYa3owFSqF38uOrGDGT.idV.leQj47Bi6mlnMstcrcNfPqvjvJC', '646f27d0f2854.png', NULL,
        '2023-05-25 11:17:18'),
       (7, 'Saša', 'Bůčková', 'F', 'S', '1984-05-09', 'sasa@seznam.cz',
        '$2y$10$D/pgCANQUat1qXop0uNl9uY/djyjX2nmGd.JjnGXCECBuaN0YpPSS', '646f286525551.png', NULL,
        '2023-05-25 11:19:59'),
       (8, 'Marcelka', 'Divićová', 'F', 'S', '1984-04-07', 'marcelka@centrum.cz',
        '$2y$10$G6FG2Q.DhRoDq.YpXQ9JYuTggzWZyPnCsljno1K2ddchSLMbnKmEi', '646f28c44170d.png', NULL,
        '2023-05-25 11:21:36'),
       (9, 'Tadeáš', 'Petránek', 'M', 'Q', '2002-06-25', 'tadeas.petranek@gmail.com',
        '$2y$10$OM2Lv4xekEvwOcbrGBuA2enDG7yi4bfL3NedF2oFNuzC2JNvO080a', '648039b798295.jpg',
        'Jsem tadeáš a frajer ale ne frajer jako Adam', '2023-06-07 10:02:10'),
       (10, 'Jakub', 'Svoboda', 'FtM', 'A', '1999-06-10', 'jakub@svoboda.cz',
        '$2y$10$wGkVQlaAWxYYDqc9TNY9VO7XWQcE5MMAU9adf.PUV2MXDRqHaBZFO', '64803a3fdccb0.jpg', 'Jsem Kuba a hraju CSGO',
        '2023-06-07 10:03:50'),
       (11, 'Jan', 'Semerák', 'MtF', 'A', '1836-04-24', 'jan@semerak.cz',
        '$2y$10$aM2WPGfMigNa/rjQqghqhu6XozQ1w95cdv9i0Xp0Lql5kkO0lqy4K', '64803ab8b76c3.jpg',
        'Jsem Jak Semerák a hraju CSGO docela dobře', '2023-06-07 10:06:44'),
       (12, 'Adam', 'Procházka', 'M', 'B', '1994-06-27', 'adam@prochazka.cz',
        '$2y$10$QyK.tnDLPkIYZZbQ1EOjjurKsaMkJiR5Pi.9fIzKmoeeWzkwh/BCC', '64804202e2f5e.jpg', 'Jsem frajer',
        '2023-06-07 10:37:04'),
       (13, 'Richard', 'Malý', 'M', 'Q', '1992-10-10', 'adamko@niggman.cz',
        '$2y$10$8./m2LF7Z0SoGV8NMBSM7uihotcK87baXOVh88mDmYRTsEmRc1WlC', '65b0cc3e95acc.jpg', 'mamam',
        '2023-11-29 12:47:55'),
       (14, 'Josef', 'Kasdi', 'M', 'S', '2005-01-01', 'smrdimivajca@vajca.com',
        '$2y$10$l83fxdShC21CGk98u0K.buKECAJSqLHvIaZTtD1czScl0p06R3Zi.', 'default.png', NULL, '2023-11-29 12:52:31'),
       (15, 'valerie', 'morstesjlfkdjlkbjfdl', 'F', '?', '2000-08-23', 'valerie@kokoska.cz',
        '$2y$10$EHH2WfWN6qI/cXFP9MvMHuImcpskp1g6gmVSoE2knq6M0RQdzY/Zm', '65b0cc274eebc.jpg', NULL,
        '2024-01-19 13:50:43'),
       (16, 'Matej', 'Landa', 'M', '?', '2004-03-30', 'landa@spsejecna.cz',
        '$2y$10$JLQ/GlCb9iXa3xY5k3mjQOZ9/vPjoaIEvo01AIG2Pl/4H0AWIobdm', '65f17b757a4f6.png', 'dem ven a ja ti tren',
        '2024-01-24 09:39:54'),
       (17, 'Michal', 'Hrouda', 'FtM', '?', '1922-01-13', 'hrouda@spsejecna.cz',
        '$2y$10$CG/3u1QdR5brTU1pNm9nuOFTlPdcHQLAgqAmJQN.8soIOdqdiOEva', 'default.png',
        'Jsem útočná helikoptéra co hledá predátora', '2024-01-24 10:15:13'),
       (18, 'Bohdan', 'Rapper', 'MtF', 'A', '2058-02-11', 'kharchenko@spsejecna.cz',
        '$2y$10$6gZmUCUSzMVn3Zr/Lqc2M.ElBPZoFCwgt3p.4Elk0IhSf/VwbcWVG', 'default.png', NULL, '2024-01-24 10:20:29'),
       (19, 'Vladimír', 'Mládek', 'M', 'S', '2005-08-18', 'lukas@masopust.zdarlidi',
        '$2y$10$jn8KnKUQUSZ8fLEd/Ydt2euzIhV0ArdR0rYkLE9I2.kJ4MnQj74XS', '65f17d5e58055.jpg',
        'Hledam Honzu Vylitu, prosim odměna párek v rohlíku', '2024-03-13 11:14:07');

DROP TABLE IF EXISTS `dates`;
CREATE TABLE `dates`
(
    `ID`             int                                                         NOT NULL AUTO_INCREMENT,
    `senderId`       int                                                         NOT NULL,
    `recipientId`    int                                                         NOT NULL,
    `dateCreated`    datetime                                                    NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of creating an invitation',
    `dateInvitation` datetime                                                    NOT NULL COMMENT 'Date stated in the invitation',
    `message`        varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci          DEFAULT NULL COMMENT 'A message from sender',
    `place`          varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Place from the invitation',
    `confirmed`      tinyint(1)                                                           DEFAULT NULL,
    PRIMARY KEY (`ID`),
    KEY `dates_credentials_ID_fk` (`senderId`),
    KEY `dates_credentials_ID_fk_2` (`recipientId`),
    CONSTRAINT `dates_credentials_ID_fk` FOREIGN KEY (`senderId`) REFERENCES `credentials` (`ID`),
    CONSTRAINT `dates_credentials_ID_fk_2` FOREIGN KEY (`recipientId`) REFERENCES `credentials` (`ID`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 65
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

TRUNCATE `dates`;
INSERT INTO `dates` (`ID`, `senderId`, `recipientId`, `dateCreated`, `dateInvitation`, `message`, `place`, `confirmed`)
VALUES (64, 2, 11, '2024-03-28 22:19:54', '2024-03-29 10:00:00', '', 'weweqg', NULL);

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`
(
    `ID`          int                                                 NOT NULL AUTO_INCREMENT,
    `sender_id`   int                                                 NOT NULL,
    `receiver_id` int                                                 NOT NULL,
    `message`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
    `created_at`  timestamp                                           NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    KEY `sender_id` (`sender_id`),
    KEY `receiver_id` (`receiver_id`),
    CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `credentials` (`ID`),
    CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `credentials` (`ID`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 10
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

TRUNCATE `messages`;
INSERT INTO `messages` (`ID`, `sender_id`, `receiver_id`, `message`, `created_at`)
VALUES (1, 2, 4, 'Ahoj! Tohle napsal Matyáš', '2024-03-27 08:07:30'),
       (2, 4, 2, 'Nazdar bejku!', '2024-03-27 08:08:16'),
       (3, 2, 4, 'TEST', '2024-03-27 09:35:29'),
       (4, 2, 4, 'AHOOOJ', '2024-03-27 09:35:40'),
       (5, 4, 2, 'Seš zmrd', '2024-03-27 10:13:49'),
       (6, 4, 2, 'TEST', '2024-03-27 10:14:47'),
       (7, 13, 2, 'Miluju tě', '2024-03-27 10:54:11'),
       (8, 2, 13, 'Já tebe ne :(', '2024-03-27 10:58:58'),
       (9, 2, 4, 'SMRD', '2024-03-28 16:52:18');

DROP TABLE IF EXISTS `room_messages`;
CREATE TABLE `room_messages`
(
    `ID`         int NOT NULL AUTO_INCREMENT,
    `room_id`    int NOT NULL,
    `message_id` int NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `room_id` (`room_id`),
    KEY `message_id` (`message_id`),
    CONSTRAINT `room_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`ID`),
    CONSTRAINT `room_messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`ID`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_czech_ci;

TRUNCATE `room_messages`;

-- 2024-03-28 22:38:03


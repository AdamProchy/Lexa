-- Adminer 4.8.1 MySQL 8.0.36-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `MojeRande`;
CREATE DATABASE `MojeRande` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `MojeRande`;

CREATE TABLE `chat_rooms` (
                              `ID` int NOT NULL AUTO_INCREMENT,
                              `user1_id` int NOT NULL,
                              `user2_id` int NOT NULL,
                              `last_message` datetime DEFAULT NULL,
                              PRIMARY KEY (`ID`),
                              KEY `user1_id` (`user1_id`),
                              KEY `user2_id` (`user2_id`),
                              CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `credentials` (`ID`),
                              CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `credentials` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `chat_rooms` (`ID`, `user1_id`, `user2_id`, `last_message`) VALUES
                                                                            (1,	16,	36,	NULL),
                                                                            (2,	23,	36,	NULL),
                                                                            (3,	35,	23,	NULL),
                                                                            (4,	35,	31,	NULL);

CREATE TABLE `credentials` (
                               `ID` int NOT NULL AUTO_INCREMENT,
                               `firstName` varchar(80) COLLATE utf8mb4_czech_ci NOT NULL,
                               `lastName` varchar(80) COLLATE utf8mb4_czech_ci NOT NULL,
                               `gender` varchar(3) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'M(ale)\r\nF(emale)\r\nMtF (Trans female)\r\nFtM (Trans male)',
                               `sexuality` varchar(1) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'S(traight)\r\nG(ay)\r\nL(esbian)\r\nB(isexual)\r\nA(sexual)\r\nD(emisexual)\r\nP(ansexual)\r\nQ(ueer)\r\n?(Questioning)',
                               `birthDate` date NOT NULL,
                               `email` varchar(80) COLLATE utf8mb4_czech_ci NOT NULL,
                               `psw` char(255) COLLATE utf8mb4_czech_ci NOT NULL,
                               `profilePicture` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'default.png',
                               `aboutMe` varchar(100) COLLATE utf8mb4_czech_ci DEFAULT NULL,
                               `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration date (automatic)',
                               PRIMARY KEY (`ID`),
                               UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `credentials` (`ID`, `firstName`, `lastName`, `gender`, `sexuality`, `birthDate`, `email`, `psw`, `profilePicture`, `aboutMe`, `reg_date`) VALUES
                                                                                                                                                           (1,	'Admin',	'Admin',	'M',	'S',	'2004-11-13',	'admin@admin.com',	'$2y$10$bJxEGMf4NsVaU9fP1RR5C.M/O55Dl3dzsjQpw0caKATKAWUPb4776',	'646f244e6f9f6.png',	NULL,	'2023-04-26 16:47:53'),
                                                                                                                                                           (16,	'Matyáš',	'Závora',	'M',	'S',	'2004-11-13',	'matyaszavora@outlook.com',	'$2y$10$1Q.Fm4aMz.QWz2QSv58pW.tQgfGeY1DYR9E.ZP8cEI1FncOJ1UKZS',	'6476f92b0cd8e.png',	'Sem frajer 💪',	'2023-05-24 08:44:02'),
                                                                                                                                                           (19,	'Lexa',	'Bůček',	'M',	'S',	'1984-07-26',	'leksa@seznam.cz',	'$2y$10$lpelvmgnxlpXpAMrvAzYs.rcN9TA/5JTaTaUe0Zl0aafMaJZqu8gi',	'646f2590577c1.jpg',	'kys',	'2023-05-25 11:00:41'),
                                                                                                                                                           (20,	'Ozzák',	'Pacovský',	'M',	'S',	'1984-02-14',	'ozzak@seznam.cz',	'$2y$10$jKSpmU4SMXiUXwj/8qTes.F47PZANxQHolNGun0YBZrfBwjeZTjuK',	'646f26025991e.png',	NULL,	'2023-05-25 11:09:41'),
                                                                                                                                                           (21,	'Tomáš ',	'Pacovský',	'M',	'S',	'1962-12-07',	'tomipaci@centrum.cz',	'$2y$10$jLgDcjpRfX2WjZERQiIQweEROmW1NhLu2pAOY9BP4MSIGAw2znueK',	'646f27341befb.png',	NULL,	'2023-05-25 11:13:27'),
                                                                                                                                                           (22,	'Iva',	'Pacovská',	'F',	'S',	'1999-03-07',	'ivuska@gmail.com',	'$2y$10$qkYYa3owFSqF38uOrGDGT.idV.leQj47Bi6mlnMstcrcNfPqvjvJC',	'646f27d0f2854.png',	NULL,	'2023-05-25 11:17:18'),
                                                                                                                                                           (23,	'Saša',	'Bůčková',	'F',	'S',	'1984-05-09',	'sasa@seznam.cz',	'$2y$10$D/pgCANQUat1qXop0uNl9uY/djyjX2nmGd.JjnGXCECBuaN0YpPSS',	'646f286525551.png',	NULL,	'2023-05-25 11:19:59'),
                                                                                                                                                           (24,	'Marcelka',	'Divićová',	'F',	'S',	'1984-04-07',	'marcelka@centrum.cz',	'$2y$10$G6FG2Q.DhRoDq.YpXQ9JYuTggzWZyPnCsljno1K2ddchSLMbnKmEi',	'646f28c44170d.png',	NULL,	'2023-05-25 11:21:36'),
                                                                                                                                                           (29,	'Tadeáš',	'Petránek',	'M',	'Q',	'2002-06-25',	'tadeas.petranek@gmail.com',	'$2y$10$OM2Lv4xekEvwOcbrGBuA2enDG7yi4bfL3NedF2oFNuzC2JNvO080a',	'648039b798295.jpg',	'Jsem tadeáš a frajer ale ne frajer jako Adam',	'2023-06-07 10:02:10'),
                                                                                                                                                           (30,	'Jakub',	'Svoboda',	'FtM',	'A',	'1999-06-10',	'jakub@svoboda.cz',	'$2y$10$wGkVQlaAWxYYDqc9TNY9VO7XWQcE5MMAU9adf.PUV2MXDRqHaBZFO',	'64803a3fdccb0.jpg',	'Jsem Kuba a hraju CSGO',	'2023-06-07 10:03:50'),
                                                                                                                                                           (31,	'Jan',	'Semerák',	'MtF',	'A',	'1836-04-24',	'jan@semerak.cz',	'$2y$10$aM2WPGfMigNa/rjQqghqhu6XozQ1w95cdv9i0Xp0Lql5kkO0lqy4K',	'64803ab8b76c3.jpg',	'Jsem Jak Semerák a hraju CSGO docela dobře',	'2023-06-07 10:06:44'),
                                                                                                                                                           (32,	'Adam',	'Procházka',	'M',	'B',	'1994-06-27',	'adam@prochazka.cz',	'$2y$10$QyK.tnDLPkIYZZbQ1EOjjurKsaMkJiR5Pi.9fIzKmoeeWzkwh/BCC',	'64804202e2f5e.jpg',	'Jsem frajer',	'2023-06-07 10:37:04'),
                                                                                                                                                           (33,	'Richard',	'Malý',	'M',	'Q',	'1992-10-10',	'adamko@niggman.cz',	'$2y$10$8./m2LF7Z0SoGV8NMBSM7uihotcK87baXOVh88mDmYRTsEmRc1WlC',	'65b0cc3e95acc.jpg',	'mamam',	'2023-11-29 12:47:55'),
                                                                                                                                                           (34,	'Josef',	'Kasdi',	'M',	'S',	'2005-01-01',	'smrdimivajca@vajca.com',	'$2y$10$l83fxdShC21CGk98u0K.buKECAJSqLHvIaZTtD1czScl0p06R3Zi.',	'default.png',	NULL,	'2023-11-29 12:52:31'),
                                                                                                                                                           (35,	'valerie',	'morstesjlfkdjlkbjfdl',	'F',	'?',	'2000-08-23',	'valerie@kokoska.cz',	'$2y$10$EHH2WfWN6qI/cXFP9MvMHuImcpskp1g6gmVSoE2knq6M0RQdzY/Zm',	'65b0cc274eebc.jpg',	NULL,	'2024-01-19 13:50:43'),
                                                                                                                                                           (36,	'Matej',	'Landa',	'M',	'?',	'2004-03-30',	'landa@spsejecna.cz',	'$2y$10$JLQ/GlCb9iXa3xY5k3mjQOZ9/vPjoaIEvo01AIG2Pl/4H0AWIobdm',	'65f17b757a4f6.png',	'dem ven a ja ti tren',	'2024-01-24 09:39:54'),
                                                                                                                                                           (37,	'Michal',	'Hrouda',	'FtM',	'?',	'1922-01-13',	'hrouda@spsejecna.cz',	'$2y$10$CG/3u1QdR5brTU1pNm9nuOFTlPdcHQLAgqAmJQN.8soIOdqdiOEva',	'default.png',	'Jsem útočná helikoptéra co hledá predátora',	'2024-01-24 10:15:13'),
                                                                                                                                                           (38,	'Bohdan',	'Rapper',	'MtF',	'A',	'2058-02-11',	'kharchenko@spsejecna.cz',	'$2y$10$6gZmUCUSzMVn3Zr/Lqc2M.ElBPZoFCwgt3p.4Elk0IhSf/VwbcWVG',	'default.png',	NULL,	'2024-01-24 10:20:29'),
                                                                                                                                                           (39,	'Vladimír',	'Mládek',	'M',	'S',	'2005-08-18',	'lukas@masopust.zdarlidi',	'$2y$10$jn8KnKUQUSZ8fLEd/Ydt2euzIhV0ArdR0rYkLE9I2.kJ4MnQj74XS',	'65f17d5e58055.jpg',	'Hledam Honzu Vylitu, prosim odměna párek v rohlíku',	'2024-03-13 11:14:07');

CREATE TABLE `dates` (
                         `ID` int NOT NULL AUTO_INCREMENT,
                         `senderEmail` varchar(80) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Email of the person that sends invitation',
                         `recipientEmail` varchar(80) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Email of the person that receives invitation',
                         `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of creating an invitation',
                         `dateInvitation` datetime NOT NULL COMMENT 'Date stated in the invitation',
                         `message` varchar(150) COLLATE utf8mb4_czech_ci DEFAULT NULL COMMENT 'A message from sender',
                         `place` varchar(150) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Place from the invitation',
                         `confirmed` tinyint(1) DEFAULT NULL,
                         PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `dates` (`ID`, `senderEmail`, `recipientEmail`, `dateCreated`, `dateInvitation`, `message`, `place`, `confirmed`) VALUES
                                                                                                                                  (20,	'ozzak@seznam.cz',	'adam@prochazka.cz',	'2023-06-07 10:43:57',	'2023-06-08 12:30:00',	'fdsfs\r\n',	'dksůlf',	1),
                                                                                                                                  (24,	'valerie@kokoska.cz',	'jan@semerak.cz',	'2024-01-19 13:52:27',	'2024-12-23 23:00:00',	'smrdis',	'vysehrad',	1),
                                                                                                                                  (25,	'landa@spsejecna.cz',	'sasa@seznam.cz',	'2024-01-24 09:41:13',	'2024-01-25 12:12:00',	'antigenni fyziolog je nejlepsi profese pod sluncem',	'u me doma',	1),
                                                                                                                                  (36,	'landa@spsejecna.cz',	'sasa@seznam.cz',	'2024-03-13 08:03:44',	'2024-02-29 13:02:00',	'hgůlgdhgfbgnliudjuzragVFvsnhgmufi',	'fdfs',	1),
                                                                                                                                  (39,	'landa@spsejecna.cz',	'sasa@seznam.cz',	'2024-03-13 08:04:57',	'2024-03-03 03:32:00',	'gfdsvfdsgfdsg',	'gfdgfdsgfdgfd',	NULL),
                                                                                                                                  (40,	'landa@spsejecna.cz',	'matyaszavora@outlook.com',	'2024-03-13 11:11:45',	'2024-07-17 17:00:00',	'jsi tlustej boy',	'Praha Prc',	1),
                                                                                                                                  (41,	'lukas@masopust.zdarlidi',	'sasa@seznam.cz',	'2024-03-13 12:58:40',	'2024-03-14 23:59:00',	'',	'ugabuga',	NULL),
                                                                                                                                  (42,	'lukas@masopust.zdarlidi',	'tadeas.petranek@gmail.com',	'2024-03-13 13:00:23',	'2024-03-14 03:00:00',	'',	'<script>alert(\"mandík smrdí\")</script>',	NULL),
                                                                                                                                  (43,	'lukas@masopust.zdarlidi',	'ozzak@seznam.cz',	'2024-03-13 13:02:40',	'2024-03-14 04:04:00',	'',	'<script> function myFunction() {   window.open(\"https://www.w3schools.com\"); } ) </script>',	NULL),
                                                                                                                                  (44,	'valerie@kokoska.cz',	'sasa@seznam.cz',	'2024-03-21 10:09:56',	'2024-03-29 12:00:00',	'TWST',	'DOAM',	NULL);

CREATE TABLE `messages` (
                            `ID` int NOT NULL AUTO_INCREMENT,
                            `sender_id` int NOT NULL,
                            `receiver_id` int NOT NULL,
                            `message` text NOT NULL,
                            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`ID`),
                            KEY `sender_id` (`sender_id`),
                            KEY `receiver_id` (`receiver_id`),
                            CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `credentials` (`ID`),
                            CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `credentials` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `room_messages` (
                                 `ID` int NOT NULL AUTO_INCREMENT,
                                 `room_id` int NOT NULL,
                                 `message_id` int NOT NULL,
                                 PRIMARY KEY (`ID`),
                                 KEY `room_id` (`room_id`),
                                 KEY `message_id` (`message_id`),
                                 CONSTRAINT `room_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`ID`),
                                 CONSTRAINT `room_messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-03-21 09:33:43

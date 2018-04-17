-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 17 avr. 2018 à 03:38
-- Version du serveur :  10.1.31-MariaDB
-- Version de PHP :  7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `foodorder`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `LastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Birth` varchar(250) NOT NULL,
  `Mail` varchar(120) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Country` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CardNumber` varchar(300) NOT NULL,
  `NameOwnerCard` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndDate` varchar(250) NOT NULL,
  `SecurityCode` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`LastName`, `FirstName`, `Birth`, `Mail`, `Password`, `Country`, `City`, `Address`, `CardNumber`, `NameOwnerCard`, `EndDate`, `SecurityCode`) VALUES
('j', 'j', '2020-02-20', 'j', '363b122c528f54df4a0446b6bab05515', 'j', 'j', 'j', '363b122c528f54df4a0446b6bab05515', '', '347140a3fba6bd6127a5b5aac232a8e2', '363b122c528f54df4a0446b6bab05515'),
('j', 'j', '2020-02-20', 'j', '363b122c528f54df4a0446b6bab05515', 'j', 'j', 'j', '363b122c528f54df4a0446b6bab05515', 'j', '347140a3fba6bd6127a5b5aac232a8e2', '363b122c528f54df4a0446b6bab05515'),
('j', 'j', '2018-04-06', 'jja', '363b122c528f54df4a0446b6bab05515', 'j', 'j', 'j', 'a78c5bf69b40d464b954ef76815c6fa0', 'j', 'f19a2d497483e2ddcc200860e6a7de15', '0cc175b9c0f1b6a831c399e269772661'),
('c', 'c', '4444-02-27', 'c', '4a8a08f09d37b73795649038408b5f33', 'c', 'c', 'c', '4a8a08f09d37b73795649038408b5f33', 'c', '83c8527e65bb59a2f15c008574e617b1', '4a8a08f09d37b73795649038408b5f33'),
('r', 'r', '2018-03-28', 'r', '4b43b0aee35624cd95b910189b3dc231', 'r', 'r', 'r', '4b43b0aee35624cd95b910189b3dc231', 'r', '9f3c0fa06c6f9d0fc49eb6e087a664c2', '4b43b0aee35624cd95b910189b3dc231'),
('p', 'p', '2018-03-28', 'p', '83878c91171338902e0fe0fb97a8c47a', 'p', 'p', 'p', '83878c91171338902e0fe0fb97a8c47a', 'p', 'b8430fffa9dd43fa1ae52a39ae2a8298', '83878c91171338902e0fe0fb97a8c47a'),
('u', 'u', '2018-04-12', 'u', '7b774effe4a349c6dd82ad4f4f21d34c', 'u', 'u', 'u', '7b774effe4a349c6dd82ad4f4f21d34c', 'u', '17528dad3a2d7cba7312cf58f3de600a', '7b774effe4a349c6dd82ad4f4f21d34c'),
('d', 'd', '2018-04-13', 'd', '8277e0910d750195b448797616e091ad', 'd', 'd', 'd', '8277e0910d750195b448797616e091ad', 'd', '17528dad3a2d7cba7312cf58f3de600a', '8277e0910d750195b448797616e091ad'),
('z', 'z', '2018-03-29', 'z', 'fbade9e36a3f36d3d676c1b808451dd7', 'z', 'z', 'z', 'fbade9e36a3f36d3d676c1b808451dd7', 'z', '9f3c0fa06c6f9d0fc49eb6e087a664c2', 'fbade9e36a3f36d3d676c1b808451dd7'),
('m', 'm', '2018-01-02', 'm', '6f8f57715090da2632453988d9a1501b', 'm', 'm', 'm', '6f8f57715090da2632453988d9a1501b', 'm', '2576c96285e66bb8420c4278cad2b186', '6f8f57715090da2632453988d9a1501b'),
('jean', 'jean', '2018-04-04', 'jean', 'b71985397688d6f1820685dde534981b', 'jean', 'jean', 'jean', 'b71985397688d6f1820685dde534981b', 'jean', 'c86f5c2b0e75f702a1b419ac64c80dac', 'b71985397688d6f1820685dde534981b');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

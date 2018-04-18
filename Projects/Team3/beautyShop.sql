-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2018 at 08:24 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautyShop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `idAd` int(20) NOT NULL,
  `street` varchar(300) NOT NULL,
  `city` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `postalCode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`idAd`, `street`, `city`, `region`, `postalCode`) VALUES
(1, '52 Rue Camille Desmoulins', 'Cachan', 'IDF', '94230'),
(2, '13 Rue Deschamps', 'Paris', 'IDF', '75000'),
(3, '2 Rue de La Paix', 'Paris', 'IDF', '75001'),
(4, '777 Boulevard Robert-Bourassa', 'Montreal', 'QC', 'H3C 3Z7');

-- --------------------------------------------------------

--
-- Table structure for table `cb`
--

CREATE TABLE `cb` (
  `idCB` int(20) NOT NULL,
  `typeCB` varchar(20) NOT NULL,
  `numCB` int(50) NOT NULL,
  `expDate` date NOT NULL,
  `idUser` int(11) NOT NULL,
  `crypto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cb`
--

INSERT INTO `cb` (`idCB`, `typeCB`, `numCB`, `expDate`, `idUser`, `crypto`) VALUES
(1, 'VISA', 12345, '2018-07-04', 4, 123),
(2, 'Amarican Express', 345789, '2018-04-09', 5, 765);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `idHist` int(20) NOT NULL,
  `datePurchase` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `idItem` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`idItem`, `name`, `code`, `image`, `price`, `type`) VALUES
(1, 'Matte lipstick', 'maLip2', 'imageAccessories1.jpg', 25.00, ''),
(3, 'Lotion Coco', 'loCo1', 'imageLotion1.jpg', 20.00, ''),
(2, 'Flower Shampoo', 'shamp1', 'imageShampoo1.jpg', 13.00, ''),
(4, 'Flower Conditioner', 'cond1', 'imageConditoner1.png', 13.00, ''),
(5, 'Cooler Shower Gel', 'sgel1', 'imageBodyWash1.jpg', 12.00, ''),
(7, 'Professional Shampoo', 'shamp2', 'imageShampoo2.jpg', 15.00, 'Shampoo'),
(8, 'Repair Shampoo', 'shamp3', 'imageShampoo3.jpg', 15.00, 'Shampoo'),
(9, 'Flower Shampoo', 'shamp4', 'imageShampoo4.jpg', 10.00, 'Shampoo'),
(10, 'Professional Shampoo', 'shamp5', 'imageShampoo5.jpg', 12.00, 'Shampoo'),
(11, 'Body Wash', 'bw1', 'imageBodyWash1.jpg', 12.00, 'Shower Gel'),
(12, 'Floral Body Wash', 'bw2', 'imageBodyWash2.jpg', 8.00, 'Shower Gel'),
(13, 'Le Petit Marseillais', 'bw3', 'imageBodyWash3.jpg', 7.00, 'Shower Gel'),
(14, 'Lovely Body Wash', 'bw4', 'imageBodyWash4.jpg', 12.00, 'Shower Gel'),
(15, 'Nutritive Body Wash', 'bw5', 'imageBodyWash5.jpg', 8.00, 'Shower Gel'),
(18, 'Sweet Lotion', 'lo4', 'imageLotion4.jpg', 14.00, 'Lotion'),
(19, 'Charming Lotion', 'lo5', 'imageLotion5.jpg', 14.00, 'Lotion'),
(20, 'Silver Ring', 'acc2', 'imageAccessories2.jpg', 10.00, 'Accessories'),
(21, 'Silver Ring', 'acc3', 'imageAccessories3.jpg', 10.00, 'Accessories'),
(18, 'Silver Necklace', 'acc4', 'imageAccessories4.jpg', 12.00, 'Accessories'),
(19, 'The One Ring', 'acc5', 'imageAccessories5.jpg', 1000000.00, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(20) NOT NULL,
  `firstName` varchar(50) CHARACTER SET ascii NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `numTel` int(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `address` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `firstName`, `lastName`, `pseudo`, `mdp`, `email`, `birthday`, `gender`, `numTel`, `status`, `address`) VALUES
(4, 'RIVOHERINJAKANAVALONA', 'Nathalie', 'n_rivohe', '202cb962ac59075b964b07152d234b70', 'rnathalie.rivo@gmail.com', '1996-10-02', 'Female', 699531802, 'admin', 1),
(5, 'Smith', 'John', 'j_smith', '202cb962ac59075b964b07152d234b70', 'smith_john@gmail.com', '1994-04-03', 'Male', 699531802, 'user', 2),
(6, 'Bocquet', 'Anne-Laure', 'a_bocquet', '202cb962ac59075b964b07152d234b70', 'al_bocquet@gmail.com', '2018-04-16', 'Female', 657468392, 'admin', 3),
(8, 'Dupont', 'Jacob', 'j_dupont', '202cb962ac59075b964b07152d234b70', 'dupont.jacob@gmail.com', '2018-04-23', 'Male', 770587318, 'user', 1),
(9, 'Fortino', 'Guiseppe', 'g_fortino', '202cb962ac59075b964b07152d234b70', 'g.fortino@gmail.com', '2018-04-17', 'Male', 2147483647, 'user', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD UNIQUE KEY `address_unique_id` (`idAd`);

--
-- Indexes for table `cb`
--
ALTER TABLE `cb`
  ADD PRIMARY KEY (`idCB`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD UNIQUE KEY `history_unique_id` (`idHist`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `address_index` (`address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `idAd` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cb`
--
ALTER TABLE `cb`
  MODIFY `idCB` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cb`
--
ALTER TABLE `cb`
  ADD CONSTRAINT `cb_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

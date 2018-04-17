-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 17 Avril 2018 à 14:31
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `id_picture` int(11) NOT NULL,
  `path` varchar(200) NOT NULL,
  `id_travel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`id_picture`, `path`, `id_travel`) VALUES
(1, 'V/images/Norvege/paysages-norvege-timelapse-1.jpg', 1),
(2, 'V/images/Norvege/paysages-norvege-timelapse-3.jpg', 1),
(3, 'V/images/Norvege/paysages-norvege-timelapse-7.jpg', 1),
(4, 'V/images/Norvege/paysages-norvege-timelapse-8.jpg', 1),
(5, 'V/images/Norvege/The-Norway-scenery-mountains-and-houses_1600x900.jpg', 1),
(14, 'V/images/Sardaigne/sardaigne.jpg', 2),
(13, 'V/images/Sardaigne/Croisiere-voilier-Corse-La-Madalenna.jpg', 2),
(12, 'V/images/Sardaigne/budoni.jpg', 2),
(11, 'V/images/Sardaigne/Castelsardo01.jpg', 2),
(16, 'V/images/Danube/30072-1500x1008.jpg', 3),
(17, 'V/images/Danube/bigstock-parliament-building-in-budapes-39286786.jpg', 3),
(18, 'V/images/Danube/58232cb2-1d23-42a2-a5e5-ca5138800ff4.jpg', 3),
(19, 'V/images/Danube/budapest_by_drone.jpeg', 3),
(20, 'V/images/Danube/Austria_Lake_Mountains_464946.jpg', 3),
(21, 'V/images/Danube/picture.11.jpg', 3),
(22, 'V/images/Danube/ringstrasse-naturhistorisches-museum-kunsthistorisches-museum-volksgarten-parlament-palais-epstein-40711-19to1.jpeg', 3),
(23, 'V/images/Egypte/B_1_philae1.jpg', 4),
(24, 'V/images/Egypte/578.jpg', 4),
(25, 'V/images/Egypte/531841226_Temple-of-Ramesses-II--Abu-Simbel--Egypt.jpg', 4),
(30, 'V/images/plaza.jpg', 5),
(27, 'V/images/Egypte/Free-Download-Nile-River-HD-Wallpaper.jpg', 4),
(28, 'V/images/Egypte/landscape_a7694bb7.jpg', 4),
(29, 'V/images/Egypte/assouan.png', 4),
(31, 'V/images/Plaza/chambre.jpg', 5),
(32, 'V/images/Plaza/hall.jpg', 5),
(33, 'V/images/Plaza/jardin.jpg', 5),
(34, 'V/images/Plaza/piscine.jpg', 5),
(35, 'V/images/Plaza/resto.jpg', 5),
(36, 'V/images/Plaza/sdb.jpg', 5),
(37, 'V/images/GeorgeV/img1.jpeg', 6),
(38, 'V/images/GeorgeV/gv2.jpg', 6),
(39, 'V/images/GeorgeV/restoG.jpg', 6),
(40, 'V/images/GeorgeV/piscineG.jpg', 6),
(41, 'V/images/GeorgeV/hall.jpg', 6),
(42, 'V/images/GeorgeV/lobby.jpg', 6);

-- --------------------------------------------------------

--
-- Structure de la table `reserve`
--

CREATE TABLE `reserve` (
  `id_res` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_travel` int(11) NOT NULL,
  `datebeg` date NOT NULL,
  `dateend` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `reserve`
--

INSERT INTO `reserve` (`id_res`, `id_user`, `id_travel`, `datebeg`, `dateend`) VALUES
(1, 4, 1, '2018-04-17', '2018-04-24'),
(3, 3, 1, '2018-04-17', '2018-04-18'),
(4, 3, 4, '2018-05-17', '2018-04-24'),
(5, 3, 1, '2010-03-23', '2010-12-20'),
(6, 3, 1, '1231-02-01', '3211-04-13'),
(7, 3, 1, '1231-02-01', '3211-04-13');

-- --------------------------------------------------------

--
-- Structure de la table `travel`
--

CREATE TABLE `travel` (
  `id_travel` int(11) NOT NULL,
  `Country` varchar(100) COLLATE utf8_bin NOT NULL,
  `Title` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_return` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `travel`
--

INSERT INTO `travel` (`id_travel`, `Country`, `Title`, `description`, `price`, `date_start`, `date_return`) VALUES
(1, 'NORWAY', 'On the land of the Vikings', 'True cultural discovery, you will discover the country of the vikings in all its splendor. From Oslo to Sognefjord via the famous Troll route, you will have the opportunity to see Norway s most beautiful fjords.', 5000, '2018-03-23', '2018-03-30'),
(2, 'ITALY', 'Combined culture and nature', 'Arbatax located in the east center of the island including a wild nature reserve integrated in a resort on the coast', 2860, '2018-03-23', '2018-03-30'),
(3, 'FRANCE', 'To conquer the East', 'From the city center to the European Parliament, passing through the imperial district of Neustadt, discover Strasbourg from a unique point of view, for a stroll along the water!', 4120, '2018-03-23', '2018-03-30'),
(4, 'EGYPT', 'The domain of the pharaohs', 'Egypt welcomes you with its mighty Nile and magnificent monuments, the beguiling desert and lush delta, and with its long past and welcoming, story-loving people.', 3250, '2018-03-23', '2018-03-30'),
(5, 'FRANCE', 'Le plaza athenee', 'The Plaza Athénée is part of the very closed circle of Parisian palaces. After 11 months of work, it reopened in September 2014, and we find everything that makes the soul of the hotel: classic and luxurious suites, a restaurant completely transformed and taken over by Alain Ducasse, the same upscale service that has made it famous, a large, refurbished interior courtyard, and still the Dior spa.', 5, '2018-03-23', '2018-03-30'),
(6, 'FRANCE', 'Le George V', 'The Four Seasons Hotel George V is one of those hotels that you probably do not need to present. Anchored since 1928 at 31 avenue George V in the 8th arrondissement just a stone s throw from the Champs Elysées, this establishment (built to the distinction of Palace in 2012) is an exceptional hotel, renowned throughout the world and with an irreproachable quality of service. ', 5, '2018-03-23', '2018-03-30'),
(7, 'Australia', 'Novotel Sydney Darling Harbour', 'A 3-minute walk from Harborside Shopping Center, Novotel Sydney Darling Harbor offers spacious rooms, some with stunning views of the Sydney skyline. It features a gym and an outdoor pool and tennis court. In addition, guests can enjoy 30 minutes of free Wi-Fi in the lobby per device and per day.', 5, '2018-03-23', '2018-03-30'),
(8, 'Australia', 'The Westin Sydney', 'Located in Sydney s central business district, near the lively Martin Place, The Westin Sydney offers an à la carte restaurant, a bar and access to a fitness center. Luxurious rooms with personalized interiors feature flat-screen TVs. Some offer stunning views of the city. Wi-Fi is free in public areas.', 5, '2018-03-23', '2018-03-30');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `lastname` text COLLATE utf8_bin NOT NULL,
  `firstname` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `login_user` text COLLATE utf8_bin NOT NULL,
  `pass` text COLLATE utf8_bin NOT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `lastname`, `firstname`, `email`, `login_user`, `pass`, `admin`) VALUES
(1, 'DOS SANTOS', 'Julien', 'julien.dossantos@gmail.com', 'DOSSANTOS1', 'jdetu1', NULL),
(2, 'TABARE', 'Ruben', 'ruben.tabare@gmail.com', 'TABARE1', 'rtetu2', NULL),
(3, 'WANG', 'Antoine', 'AntoineWang@gmail.com', 'WANG1', 'rlXrBRAuJnsg.', 1),
(4, 'BUGIELSKI', 'Alexis', 'AlexisBugielski@gmail.com', 'BUGIELSKI1', 'baetu1', NULL),
(5, 'MONET', 'Gregoire', 'GregoireMonet@gmail.com', 'MONET1', 'gmetu1', NULL),
(6, 'WRIGHT', 'Bill', 'BillWright@gmail.com', 'WRIGHT1', 'bwetu1', NULL),
(7, 'ZUKERBERG', 'MARK', 'MarkZukerberg@gmail.com', 'ZUKERBERG1', 'mzetu1', NULL),
(8, 'CARON', 'Fabien', 'FabienCaron@gmail.com', 'CARON1', 'caetu1', NULL),
(9, 'CRESP', 'Vincent', 'VincentCresp@gmail.com', 'CRESP1', 'cvetu1', NULL),
(10, 'ASIMOV', 'Isaac', 'IsaacAsimovp@gmail.com', 'ASIMOV1', 'cvetu1', NULL),
(12, 'yo', 'yo', 'azadzd@gmail.com', 'az', 'rl7HypOhTM4Uo', NULL),
(13, 'Julien', 'Dos Santos', 'julien.dossantos@gmail.com', 'judoetu1', 'rl1IV0t8l4rcQ', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id_picture`);

--
-- Index pour la table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`id_res`);

--
-- Index pour la table `travel`
--
ALTER TABLE `travel`
  ADD PRIMARY KEY (`id_travel`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `id_picture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `id_res` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `travel`
--
ALTER TABLE `travel`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

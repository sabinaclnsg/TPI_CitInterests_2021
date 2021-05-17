-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 mai 2021 à 13:59
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `citinterests`
--

-- --------------------------------------------------------

--
-- Structure de la table `age_limit`
--

CREATE TABLE `age_limit` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `age_limit`
--

INSERT INTO `age_limit` (`id`, `name`) VALUES
(1, '0-4'),
(2, '5-7'),
(3, '7-12'),
(4, 'Adolescents'),
(5, 'Adultes');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Activité'),
(2, 'Station de montagne'),
(3, 'Balade'),
(4, 'Place de pique-nique'),
(5, 'Idée Week-end'),
(6, 'Place de jeu');

-- --------------------------------------------------------

--
-- Structure de la table `closing_hours`
--

CREATE TABLE `closing_hours` (
  `id` int(11) NOT NULL,
  `monday` time NOT NULL,
  `tuesday` time NOT NULL,
  `wednesday` time NOT NULL,
  `thursday` time NOT NULL,
  `friday` time NOT NULL,
  `saturday` time NOT NULL,
  `sunday` time NOT NULL,
  `id_sights` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `closing_hours`
--

INSERT INTO `closing_hours` (`id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `id_sights`) VALUES
<<<<<<< HEAD
(32, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 58),
(33, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 59),
(34, '03:00:00', '05:00:00', '06:00:00', '06:06:00', '06:00:00', '06:00:00', '06:00:00', 60),
(35, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 62);
=======
(25, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '16:51:00', '00:00:00', 50),
(26, '02:00:00', '02:00:00', '22:00:00', '02:00:00', '02:00:00', '21:00:00', '02:00:00', 51),
(27, '03:00:00', '03:00:00', '03:00:00', '03:00:00', '03:00:00', '03:00:00', '03:00:00', 52),
(28, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 54),
(29, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '23:00:00', '00:00:00', 55);
>>>>>>> 468a94e31cd5afdb4963aece2c5f1971d3496554

-- --------------------------------------------------------

--
-- Structure de la table `opening_hours`
--

CREATE TABLE `opening_hours` (
  `id` int(11) NOT NULL,
  `monday` time NOT NULL,
  `tuesday` time NOT NULL,
  `wednesday` time NOT NULL,
  `thursday` time NOT NULL,
  `friday` time NOT NULL,
  `saturday` time NOT NULL,
  `sunday` time NOT NULL,
  `id_sights` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opening_hours`
--

INSERT INTO `opening_hours` (`id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `id_sights`) VALUES
(32, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 58),
(33, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 59),
(34, '04:00:00', '04:00:00', '05:00:00', '05:00:00', '05:06:00', '05:00:00', '05:00:00', 60),
(35, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 62);

-- --------------------------------------------------------

--
-- Structure de la table `sights`
--

CREATE TABLE `sights` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `canton` enum('Genève','Jura','Fribourg','Neuchâtel','Vaud','Valais') NOT NULL,
  `adress` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `sights_delete_requested` tinyint(1) NOT NULL,
  `sight_showed` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sights`
--

INSERT INTO `sights` (`id`, `name`, `canton`, `adress`, `description`, `price`, `image`, `validated`, `sights_delete_requested`, `sight_showed`, `id_user`) VALUES
(58, 'Test 1', 'Genève', 'De Ternier 10', 'fgfgfjfghfjg', 12, 'michael-sum-LEpfefQf4rU-unsplash609b97cfbc0d9.jpg', 1, 0, 1, 2),
(59, 'Test 2', 'Valais', 'Rue de la Servette 82', 'fdhgfhfgh', 0, 'eric-han-Hd7vwFzZpH0-unsplash609b97ea6a467.jpg', 1, 0, 1, 2),
(60, 'Jet d&#39;Eau', 'Genève', 'Rue de la Servette 85', 'The Jet d&#39;Eau (French pronunciation: ​[ʒɛ do], Water-Jet) is a large fountain in Geneva, Switzerland and is one of the city&#39;s most famous landmarks, being featured on the city&#39;s official tourism web site and on the official logo for Geneva&#39;s hosting of group stage matches in the 2008 UEFA Euro.[1] Situated where Lake Geneva exits as the Rhône, it is visible throughout the city and from the air, even when flying over Geneva at an altitude of 10 kilometres (33,000 ft).\r\n\r\nFive hundred litres (110 imp gal; 130 US gal) of water per second are jetted to an altitude of 140 metres (460 ft) by two 500 kW pumps, operating at 2,400 V, consuming one megawatt of electricity.[2][3][4] The water leaves the 10 centimetres (3.9 in) nozzle at a speed of 200 kilometres per hour (120 mph). At any given moment, there are about 7,000 litres (1,500 imp gal; 1,800 US gal) of water in the air. Unsuspecting visitors to the fountain—which can be reached via a stone jetty from the left bank of the lake—may be surprised to find themselves drenched after a slight change in wind direction.', 0, 'jet609b9c5dc9560.jpg', 1, 0, 1, 2),
(62, 'Parc des Bastions', 'Fribourg', 'Rue de la Servette 85', 'Large city green space with a playground, 6 giant chess boards, lounge chairs & a botanical garden.', 0, 'parc-bastions-geneve609b9d5f463dd.jpg', 1, 0, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `sights_contains_category`
--

CREATE TABLE `sights_contains_category` (
  `id` int(11) NOT NULL,
  `id_sights` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sights_contains_category`
--

INSERT INTO `sights_contains_category` (`id`, `id_sights`, `id_category`) VALUES
(32, 58, 3),
(33, 58, 4),
(34, 59, 5),
(35, 59, 6),
(36, 60, 3),
(37, 60, 4),
(38, 60, 5),
(39, 62, 3);

-- --------------------------------------------------------

--
-- Structure de la table `sights_has_age_limit`
--

CREATE TABLE `sights_has_age_limit` (
  `id` int(11) NOT NULL,
  `id_sights` int(11) NOT NULL,
  `id_age_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sights_has_age_limit`
--

INSERT INTO `sights_has_age_limit` (`id`, `id_sights`, `id_age_limit`) VALUES
(24, 58, 4),
(25, 59, 5),
(26, 60, 1),
(27, 60, 2),
(28, 60, 3),
(29, 60, 4),
(30, 60, 5),
(31, 62, 1),
(32, 62, 2),
(33, 62, 3),
(34, 62, 4),
(35, 62, 5);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `status` enum('active','archived') NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `account_delete_requested` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `email`, `password`, `status`, `admin`, `banned`, `image`, `account_delete_requested`) VALUES
(2, 'Doe', 'John', 'test@gmail.com', '$2y$10$Nv8mHI2TtWrlaeDVeDncfexFsMatU5ah5/L766hrQ0ZCGz68KbwqC', 'active', 1, 0, 'image-login.jpg', 0),
(3, 'Calunsag', 'Sabina Ayenne', 'sabinaayenne@gmail.com', '$2y$10$AHkXD3yUuYOAzp0M.KuERuZJpnBgoJuuu8a/9Hn1jcdqPcuxlnfNO', 'active', 0, 0, 'profile-user-not-connected.svg', 0),
(4, 'test', 'test', 'test1@gmail.com', '$2y$10$fM/gA4XVwEg0wNXbNjfISuabOdqkY/LdQZTS7aSS4Bg9uMV77Xra.', 'active', 0, 0, 'profile-user-not-connected.svg', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `age_limit`
--
ALTER TABLE `age_limit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `closing_hours_ibfk_1` (`id_sights`);

--
-- Index pour la table `opening_hours`
--
ALTER TABLE `opening_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sights` (`id_sights`);

--
-- Index pour la table `sights`
--
ALTER TABLE `sights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `sights_contains_category`
--
ALTER TABLE `sights_contains_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_sights` (`id_sights`);

--
-- Index pour la table `sights_has_age_limit`
--
ALTER TABLE `sights_has_age_limit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_age_limit` (`id_age_limit`),
  ADD KEY `id_sights` (`id_sights`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `age_limit`
--
ALTER TABLE `age_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `closing_hours`
--
ALTER TABLE `closing_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `opening_hours`
--
ALTER TABLE `opening_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `sights`
--
ALTER TABLE `sights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `sights_contains_category`
--
ALTER TABLE `sights_contains_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `sights_has_age_limit`
--
ALTER TABLE `sights_has_age_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD CONSTRAINT `closing_hours_ibfk_1` FOREIGN KEY (`id_sights`) REFERENCES `sights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `opening_hours`
--
ALTER TABLE `opening_hours`
  ADD CONSTRAINT `opening_hours_ibfk_1` FOREIGN KEY (`id_sights`) REFERENCES `sights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sights`
--
ALTER TABLE `sights`
  ADD CONSTRAINT `sights_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sights_contains_category`
--
ALTER TABLE `sights_contains_category`
  ADD CONSTRAINT `sights_contains_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sights_contains_category_ibfk_2` FOREIGN KEY (`id_sights`) REFERENCES `sights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sights_has_age_limit`
--
ALTER TABLE `sights_has_age_limit`
  ADD CONSTRAINT `sights_has_age_limit_ibfk_1` FOREIGN KEY (`id_age_limit`) REFERENCES `age_limit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sights_has_age_limit_ibfk_2` FOREIGN KEY (`id_sights`) REFERENCES `sights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

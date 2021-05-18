-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 18 mai 2021 à 16:28
-- Version du serveur :  10.4.19-MariaDB
-- Version de PHP : 8.0.6

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
(40, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 67),
(41, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 68),
(42, '18:00:00', '18:00:00', '18:00:00', '18:00:00', '18:00:00', '18:00:00', '18:00:00', 69),
(43, '19:00:00', '19:00:00', '19:00:00', '19:00:00', '19:00:00', '00:00:00', '00:00:00', 70),
(44, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 71),
(49, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 76),
(50, '02:00:00', '02:00:00', '02:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 77),
(51, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 78),
(52, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 79),
(53, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 80),
(54, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 81);

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
(40, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 67),
(41, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 68),
(42, '11:00:00', '11:00:00', '11:00:00', '11:00:00', '11:00:00', '11:00:00', '11:00:00', 69),
(43, '10:30:00', '10:30:00', '10:30:00', '10:30:00', '10:30:00', '00:00:00', '00:00:00', 70),
(44, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 71),
(49, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 76),
(50, '01:00:00', '01:00:00', '01:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 77),
(51, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 78),
(52, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 79),
(53, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 80),
(54, '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 81);

-- --------------------------------------------------------

--
-- Structure de la table `sights`
--

CREATE TABLE `sights` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `canton` enum('Genève','Jura','Fribourg','Neuchâtel','Vaud','Valais') NOT NULL,
  `adress` varchar(100) NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `sights_delete_requested` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sights`
--

INSERT INTO `sights` (`id`, `name`, `canton`, `adress`, `telephone`, `description`, `price`, `image`, `validated`, `sights_delete_requested`, `id_user`) VALUES
(67, 'Jet d&#39;Eau', 'Genève', 'Quai Gustave-Ador, 1207 Genève', '022 349 34 76', 'The Jet d&#39;Eau (French pronunciation: ​[ʒɛ do], Water-Jet) is a large fountain in Geneva, Switzerland and is one of the city&#39;s most famous landmarks, being featured on the city&#39;s official tourism web site and on the official logo for Geneva&#39;s hosting of group stage matches in the 2008 UEFA Euro.[1] Situated where Lake Geneva exits as the Rhône, it is visible throughout the city and from the air, even when flying over Geneva at an altitude of 10 kilometres (33,000 ft).\r\n\r\nFive hundred litres (110 imp gal; 130 US gal) of water per second are jetted to an altitude of 140 metres (460 ft) by two 500 kW pumps, operating at 2,400 V, consuming one megawatt of electricity.[2][3][4] The water leaves the 10 centimetres (3.9 in) nozzle at a speed of 200 kilometres per hour (120 mph). At any given moment, there are about 7,000 litres (1,500 imp gal; 1,800 US gal) of water in the air. Unsuspecting visitors to the fountain—which can be reached via a stone jetty from the left bank of the lake—may be surprised to find themselves drenched after a slight change in wind direction.', 0, 'jet60a3840c27a55.jpg', 1, 0, 2),
(68, 'Parc des Bastions', 'Genève', 'Prom. des Bastions 1, 1205 Genève', '022 234 56 87', 'Parc des Bastions, or Bastions Park, is a must-visit beautiful park in the heart of Geneva, located next to Place Neuve, just under the Geneva&#39;s Old Town.\r\nBastions Parc is famous for the Reformation Wall proudly standing here, big chess boards at the entrance, great restaurant and big playground for a kids. Opposite the reformation wall stands one building of the University of Geneva and it&#39;s public library.', 0, 'parc-bastions-geneve60a258c7c0fc6.jpg', 1, 0, 2),
(69, 'Musée d&#39;Art et d&#39;Histoire', 'Genève', 'Rue Charles-Galland 2, 1206 Genève', '022 876 23 48', 'The museum is located in Les Tranchées, in the city centre, on the site of the former fortification ring. It was built by the architect Marc Camoletti between 1903 and 1910,[1] and financed by a bequest from the banker Charles Galland (1816–1901).[2] The building is square, with 60 m (200 ft) sides surrounding an inner courtyard. It has four storeys, with roof lanterns on the top floor, and a total exhibition space of 7,000 m² (75,000 square feet).[2]\r\nThe façade is decorated with sculptures by Paul Amlehn: an allegory of the arts, depicting painting, sculpture, drawing and architecture, is mounted on the triangular gable above the entrance, and two more allegories, of archaeology and applied art, can be seen in the left- and right-hand corners of the building respectively. The upper frieze includes the names of Genevan artists: Dassier, Baud-Bovy, Saint-Ours, Agasse, Töpffer, Liotard, Calame, Diday, Menn, Petitot, Arlaud and Pradier.', 5, 'téléchargé60a259bca5e2f.jpg', 1, 0, 2),
(70, 'AquaParc', 'Valais', 'Route de la Plage 122, 1897 Port-Valais', '022 322 85 21', 'Caribbean-themed water park with slides & games, plus whirlpool, saunas & a Turkish bath.', 30, '04072018-img_0816_-_copie60a25afe46ef2.jpg', 1, 0, 2),
(71, 'Jardin Anglais', 'Genève', 'Quai du Général-Guisan 34, 1204 Genève', '022 954 32 54', 'The Jardin anglais is an urban park in Geneva, Switzerland, situated at the location of an ancient harbor and a wood. It marks the beginning of the Quai Gustave-Ador. The park was created in 1855. In 1863 the building process of the Pont du Mont-Blanc changed the park to its actual form – a trapezoid/trapezium of 25430 m². The Park hosts the Le monument national and the L&#39;horloge fleurie, besides several pavilions, a sculpted bronze fountain by Alexis Andre and a coffeehouse.', 0, 'horloge-fleurie-geneve-suisse60a25be2b166c.jpg', 1, 0, 2),
(76, 'test', 'Vaud', 'Prom. des Bastions 1, 1205 Genève', '022 458 92 83', 'dfgdfg', 32, 'parc-bastions-geneve60a3c7ab39a1e.jpg', 1, 0, 2),
(77, 'testttt', 'Fribourg', 'Route de la Plage 122, 1897 Port-Valais', '022 458 92 83', 'ssf', 12, 'téléchargé60a3c7c5e682c.jpg', 1, 0, 2),
(78, 'test', 'Valais', 'Route de la Plage 122, 1897 Port-Valais', '022 458 92 83', 'sdfsf', 0, 'horloge-fleurie-geneve-suisse60a3c7d8967de.jpg', 1, 0, 2),
(79, 'sdsdfsdf', 'Valais', 'Quai du Général-Guisan 34, 1204 Genève', '022 458 92 83', 'sdfsdf', 0, 'bains-paquis-2-760x36560a3c7e9c0a03.jpg', 1, 0, 2),
(80, 'aaaaaaaaaa', 'Neuchâtel', 'Quai Gustave-Ador, 1207 Genève', '022 458 92 83', 'sdfsdfsdf', 12, '04072018-img_0816_-_copie60a3c7fc673d1.jpg', 1, 0, 2),
(81, 'Jet d&#39;Eau', 'Neuchâtel', 'Prom. des Bastions 1, 1205 Genève', '022 458 92 83', 'ada', 0, 'horloge-fleurie-geneve-suisse60a3c8256aa16.jpg', 1, 0, 2);

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
(52, 67, 3),
(53, 67, 5),
(54, 68, 3),
(55, 68, 5),
(56, 68, 6),
(57, 69, 1),
(58, 69, 3),
(59, 69, 5),
(60, 70, 1),
(61, 70, 5),
(62, 70, 6),
(63, 71, 3),
(64, 71, 5),
(74, 76, 3),
(75, 76, 4),
(76, 76, 5),
(77, 77, 1),
(78, 77, 2),
(79, 77, 6),
(80, 78, 1),
(81, 78, 5),
(82, 78, 6),
(83, 79, 5),
(84, 79, 6),
(85, 80, 1),
(86, 80, 2),
(87, 80, 4),
(88, 81, 4),
(89, 81, 5),
(90, 81, 6);

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
(45, 67, 1),
(46, 67, 2),
(47, 67, 3),
(48, 67, 4),
(49, 67, 5),
(50, 68, 1),
(51, 68, 2),
(52, 68, 3),
(53, 68, 4),
(54, 68, 5),
(55, 69, 3),
(56, 69, 4),
(57, 69, 5),
(58, 70, 2),
(59, 70, 3),
(60, 70, 4),
(61, 70, 5),
(62, 71, 1),
(63, 71, 2),
(64, 71, 3),
(65, 71, 4),
(66, 71, 5),
(75, 76, 5),
(76, 77, 2),
(77, 77, 4),
(78, 78, 1),
(79, 78, 2),
(80, 78, 4),
(81, 79, 4),
(82, 79, 5),
(83, 80, 1),
(84, 80, 2),
(85, 80, 4),
(86, 81, 4),
(87, 81, 5);

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
  `image` varchar(200) NOT NULL,
  `account_delete_requested` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `email`, `password`, `status`, `admin`, `banned`, `image`, `account_delete_requested`) VALUES
(2, 'Doe', 'John', 'test@gmail.com', '$2y$10$Nv8mHI2TtWrlaeDVeDncfexFsMatU5ah5/L766hrQ0ZCGz68KbwqC', 'active', 1, 0, '04072018-img_0816_-_copie60a383113f26d.jpg', 0),
(3, 'Calunsag', 'Sabina Ayenne', 'sabinaayenne@gmail.com', '$2y$10$AHkXD3yUuYOAzp0M.KuERuZJpnBgoJuuu8a/9Hn1jcdqPcuxlnfNO', 'active', 0, 1, 'profile-user-not-connected.svg', 0),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `opening_hours`
--
ALTER TABLE `opening_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `sights`
--
ALTER TABLE `sights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `sights_contains_category`
--
ALTER TABLE `sights_contains_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `sights_has_age_limit`
--
ALTER TABLE `sights_has_age_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

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

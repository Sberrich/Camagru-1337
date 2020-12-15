-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 15 déc. 2020 à 19:00
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP :  7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `idcmnt` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `cmntdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `img`
--

CREATE TABLE `img` (
  `imgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `imgedate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imgurl` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `comments` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `img`
--

INSERT INTO `img` (`imgid`, `userid`, `text`, `imgedate`, `imgurl`, `likes`, `comments`) VALUES
(178, 27, NULL, '2020-12-03 17:36:49', '../public/imgs/1607017008.png', 0, 11),
(181, 28, NULL, '2020-12-07 14:09:37', '../public/imgs/1607350176.png', 1, 0),
(182, 28, NULL, '2020-12-07 14:36:47', '../public/imgs/1607351806.png', 0, 1),
(183, 28, NULL, '2020-12-07 16:47:08', '../public/imgs/1607359627.png', 0, 1),
(184, 30, NULL, '2020-12-08 15:52:08', '../public/imgs/1607442727.png', 0, 3),
(185, 30, NULL, '2020-12-08 16:01:05', '../public/imgs/1607443264.png', 1, 2),
(186, 30, NULL, '2020-12-08 16:33:08', '../public/imgs/1607445188.png', 1, 14),
(187, 30, NULL, '2020-12-08 16:42:15', '../public/imgs/1607445734.png', 1, 0),
(188, 30, NULL, '2020-12-08 17:18:26', '../public/imgs/1607447905.png', 0, 1),
(189, 30, NULL, '2020-12-08 18:13:47', '../public/imgs/1607451227.png', 0, 0),
(190, 30, NULL, '2020-12-08 18:18:33', '../public/imgs/1607451513.png', 0, 0),
(191, 30, NULL, '2020-12-08 18:18:41', '../public/imgs/1607451521.png', 0, 0),
(192, 30, NULL, '2020-12-08 18:19:45', '../public/imgs/1607451585.png', 0, 0),
(193, 30, NULL, '2020-12-08 18:19:57', '../public/imgs/1607451597.png', 0, 0),
(194, 30, NULL, '2020-12-08 18:20:07', '../public/imgs/1607451607.png', 0, 0),
(195, 30, NULL, '2020-12-08 18:20:15', '../public/imgs/1607451615.png', 0, 0),
(196, 30, NULL, '2020-12-08 18:20:24', '../public/imgs/1607451624.png', 0, 0),
(197, 30, NULL, '2020-12-08 18:20:48', '../public/imgs/1607451647.png', 0, 0),
(198, 30, NULL, '2020-12-08 18:21:01', '../public/imgs/1607451661.png', 0, 0),
(199, 30, NULL, '2020-12-08 18:21:08', '../public/imgs/1607451667.png', 0, 0),
(200, 30, NULL, '2020-12-08 18:30:11', '../public/imgs/1607452210.png', 0, 0),
(201, 30, NULL, '2020-12-08 18:50:44', '../public/imgs/1607453444.png', 0, 0),
(202, 30, NULL, '2020-12-08 18:50:55', '../public/imgs/1607453455.png', 0, 0),
(203, 30, NULL, '2020-12-08 18:51:10', '../public/imgs/1607453470.png', 0, 0),
(204, 30, NULL, '2020-12-09 18:19:10', '../public/imgs/1607537949.png', 0, 0),
(205, 30, NULL, '2020-12-09 18:58:06', '../public/imgs/1607540286.png', 0, 0),
(206, 30, NULL, '2020-12-09 18:58:11', '../public/imgs/1607540291.png', 0, 0),
(207, 30, NULL, '2020-12-09 18:58:16', '../public/imgs/1607540295.png', 0, 0),
(208, 30, NULL, '2020-12-09 18:58:27', '../public/imgs/1607540307.png', 0, 0),
(209, 30, NULL, '2020-12-09 19:02:25', '../public/imgs/1607540545.png', 0, 0),
(210, 30, NULL, '2020-12-09 19:04:53', '../public/imgs/1607540693.png', 0, 0),
(211, 30, NULL, '2020-12-09 19:05:18', '../public/imgs/1607540718.png', 0, 0),
(212, 30, NULL, '2020-12-09 19:09:19', '../public/imgs/1607540959.png', 0, 0),
(213, 30, NULL, '2020-12-09 19:12:36', '../public/imgs/1607541155.png', 0, 0),
(214, 30, NULL, '2020-12-09 19:17:21', '../public/imgs/1607541441.png', 0, 0),
(215, 30, NULL, '2020-12-09 19:22:55', '../public/imgs/1607541775.png', 0, 0),
(216, 30, NULL, '2020-12-09 19:24:39', '../public/imgs/1607541879.png', 0, 0),
(217, 30, NULL, '2020-12-09 19:24:47', '../public/imgs/1607541887.png', 0, 0),
(218, 30, NULL, '2020-12-09 19:28:50', '../public/imgs/1607542129.png', 0, 0),
(219, 30, NULL, '2020-12-09 19:28:54', '../public/imgs/1607542134.png', 0, 0),
(220, 30, NULL, '2020-12-09 19:29:02', '../public/imgs/1607542142.png', 0, 0),
(221, 30, NULL, '2020-12-09 19:30:45', '../public/imgs/1607542244.png', 0, 0),
(222, 30, NULL, '2020-12-09 19:30:48', '../public/imgs/1607542248.png', 0, 0),
(223, 30, NULL, '2020-12-09 19:30:59', '../public/imgs/1607542259.png', 0, 0),
(224, 30, NULL, '2020-12-09 19:31:04', '../public/imgs/1607542264.png', 0, 0),
(225, 30, NULL, '2020-12-09 19:35:17', '../public/imgs/1607542516.png', 0, 0),
(226, 30, NULL, '2020-12-09 19:37:09', '../public/imgs/1607542629.png', 0, 0),
(227, 30, NULL, '2020-12-09 19:37:21', '../public/imgs/1607542641.png', 0, 0),
(228, 30, NULL, '2020-12-09 19:37:51', '../public/imgs/1607542670.png', 0, 0),
(229, 30, NULL, '2020-12-09 19:38:07', '../public/imgs/1607542686.png', 0, 0),
(230, 30, NULL, '2020-12-09 19:38:31', '../public/imgs/1607542711.png', 0, 0),
(231, 30, NULL, '2020-12-09 19:40:08', '../public/imgs/1607542807.png', 0, 0),
(232, 30, NULL, '2020-12-10 11:03:34', '../public/imgs/1607598214.png', 0, 0),
(233, 30, NULL, '2020-12-10 11:03:45', '../public/imgs/1607598224.png', 0, 0),
(234, 30, NULL, '2020-12-10 11:10:35', '../public/imgs/1607598635.png', 0, 0),
(235, 30, NULL, '2020-12-10 11:11:18', '../public/imgs/1607598677.png', 0, 0),
(236, 30, NULL, '2020-12-10 11:14:22', '../public/imgs/1607598861.png', 0, 0),
(237, 30, NULL, '2020-12-10 11:47:17', '../public/imgs/1607600837.png', 0, 0),
(238, 30, NULL, '2020-12-10 11:47:26', '../public/imgs/1607600846.png', 0, 0),
(239, 30, NULL, '2020-12-10 11:49:40', '../public/imgs/1607600980.png', 0, 0),
(240, 30, NULL, '2020-12-10 11:49:47', '../public/imgs/1607600987.png', 0, 0),
(241, 30, NULL, '2020-12-10 12:24:43', '../public/imgs/1607603083.png', 0, 0),
(242, 30, NULL, '2020-12-10 18:25:56', '../public/imgs/1607624756.png', 0, 0),
(243, 30, NULL, '2020-12-10 18:44:07', '../public/imgs/1607625847.png', 0, 0),
(244, 30, NULL, '2020-12-10 18:48:09', '../public/imgs/1607626089.png', 0, 0),
(245, 30, NULL, '2020-12-10 18:56:30', '../public/imgs/1607626590.png', 0, 0),
(246, 30, NULL, '2020-12-10 19:06:12', '../public/imgs/1607627171.png', 0, 0),
(247, 30, NULL, '2020-12-10 19:32:24', '../public/imgs/1607628744.png', 0, 0),
(248, 30, NULL, '2020-12-10 19:37:08', '../public/imgs/1607629028.png', 0, 0),
(249, 30, NULL, '2020-12-11 12:32:04', '../public/imgs/1607689923.png', 0, 0),
(250, 30, NULL, '2020-12-11 15:04:53', '../public/imgs/1607699092.png', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

CREATE TABLE `like` (
  `userid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL,
  `like` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT 0,
  `notification` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `token`, `confirmed`, `notification`) VALUES
(39, 'samir', 'hevera6313@febeks.com', '69eecbb474725359f06f9e42191654f5e00890217d3c821bba8a10ff0ed757b2cc38cff72dbd95f7aa71c82c1a6cd9f26737d15bd4669faac19e2afc85c16fe3', '', 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idcmnt`),
  ADD KEY `comment_ibfk` (`imgid`),
  ADD KEY `comment_ibfk_1` (`userid`);

--
-- Index pour la table `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`imgid`) USING BTREE,
  ADD KEY `userid` (`userid`);

--
-- Index pour la table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`userid`,`imgid`),
  ADD KEY `like_ibfk_2` (`imgid`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `idcmnt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT pour la table `img`
--
ALTER TABLE `img`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk` FOREIGN KEY (`imgid`) REFERENCES `img` (`imgid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`imgid`) REFERENCES `img` (`imgid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 22 jan. 2023 à 22:03
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `simplonmanager_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenoms` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `id_pays` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`id`, `nom`, `prenoms`, `telephone`, `email`, `date_creation`, `date_modification`, `id_pays`) VALUES
(19, 'AKOESSO', 'Lea', '92362425', 'lea@gmail.com', '2023-01-21 12:47:07', '2023-01-22 18:50:15', 1),
(21, 'AKOESSO', 'DODJI', '90695037', 'dodji@gmail.com', '2023-01-21 13:53:32', '2023-01-22 18:52:36', 1),
(23, 'TOUGLO', 'Pierrot', '010203405', 'pierrot@gmail.com', '2023-01-21 13:54:08', '0000-00-00 00:00:00', 1),
(26, 'AGBEGA', 'MATHIAS', '010203405', 'matias@gmail.com', '2023-01-21 14:29:28', '0000-00-00 00:00:00', 1),
(27, 'N\'GUESSAN', 'Vivien', '70020304', 'vivien@gmail.com', '2023-01-22 13:06:40', '0000-00-00 00:00:00', 5),
(28, 'N\'KPONOU', 'N\'kafio', '91909936', 'nkafio@gmail.com', '2023-01-22 13:09:46', '0000-00-00 00:00:00', 4),
(29, 'GBENOU', 'Koffi', '89654723', 'koffi@gmail.com', '2023-01-22 19:04:21', '0000-00-00 00:00:00', 2),
(30, 'KOSSI', 'Justin', '85967423', 'justin@gmail.com', '2023-01-22 19:09:22', '0000-00-00 00:00:00', 5);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `indicatif` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `libelle`, `indicatif`) VALUES
(1, 'Togo', '228'),
(2, 'Bénin', '229'),
(3, 'Cameroun', '237'),
(4, 'Ghana', '233'),
(5, 'Cote d\'ivoire', '225');

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

DROP TABLE IF EXISTS `profils`;
CREATE TABLE IF NOT EXISTS `profils` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profils`
--

INSERT INTO `profils` (`id`, `libelle`) VALUES
(1, 'admin'),
(2, 'utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenoms` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_profil` int NOT NULL,
  `compte_actif` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_profil` (`id_profil`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenoms`, `login`, `mot_de_passe`, `id_profil`, `compte_actif`) VALUES
(1, 'GBENOU', 'Kossi', 'gkossi', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1),
(2, 'GBENOU', 'Eunice', 'geunice', '81dc9bdb52d04dc20036dbd8313ed055', 2, 0),
(4, 'AKOESSO', 'Akoélé', 'nono', '81dc9bdb52d04dc20036dbd8313ed055', 1, 0),
(6, 'N\'GUESSAN', 'Vivien', 'vivien', '81dc9bdb52d04dc20036dbd8313ed055', 2, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_profil`) REFERENCES `profils` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

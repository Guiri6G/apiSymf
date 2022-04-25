-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 25 avr. 2022 à 22:07
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetapi`
--
CREATE DATABASE IF NOT EXISTS `projetapi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projetapi`;

-- --------------------------------------------------------

--
-- Structure de la table `barber`
--

DROP TABLE IF EXISTS `barber`;
CREATE TABLE IF NOT EXISTS `barber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_salon_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7C48A9A41C4A5171` (`id_salon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `barber`
--

INSERT INTO `barber` (`id`, `id_salon_id`, `nom`, `prenom`, `image_url`) VALUES
(1, 1, 'mr', 'barber 1', 'lien1'),
(2, 1, 'mr', 'barber 2', 'lien2'),
(3, 2, 'mr', 'barber 3', 'lien3'),
(4, 2, 'mr', 'barber 4', 'lien4'),
(5, 3, 'mr', 'barber 5', 'lien5');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220406224025', '2022-04-18 00:00:00', 677),
('DoctrineMigrations\\Version20220407190009', '2022-04-26 19:00:43', 768);

-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

DROP TABLE IF EXISTS `salon`;
CREATE TABLE IF NOT EXISTS `salon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salon`
--

INSERT INTO `salon` (`id`, `nom`, `localisation`, `image_url`) VALUES
(1, 'salon1', 'Montreuil', 'lien1'),
(2, 'salon2', 'Bordeaux', 'lien2'),
(3, 'salon3', 'Paris', 'lien3'),
(4, 'salon4', 'Paris', 'lien4'),
(5, 'salon5', 'Marseille', 'lien5');

-- --------------------------------------------------------

--
-- Structure de la table `slots`
--

DROP TABLE IF EXISTS `slots`;
CREATE TABLE IF NOT EXISTS `slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_salon_id` int(11) DEFAULT NULL,
  `id_barber_id` int(11) DEFAULT NULL,
  `id_user_id` int(11) DEFAULT NULL,
  `debut_rdv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fin_rdv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C87435D01C4A5171` (`id_salon_id`),
  KEY `IDX_C87435D03FC742D5` (`id_barber_id`),
  KEY `IDX_C87435D079F37AE5` (`id_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `barber`
--
ALTER TABLE `barber`
  ADD CONSTRAINT `FK_7C48A9A41C4A5171` FOREIGN KEY (`id_salon_id`) REFERENCES `salon` (`id`);

--
-- Contraintes pour la table `slots`
--
ALTER TABLE `slots`
  ADD CONSTRAINT `FK_C87435D01C4A5171` FOREIGN KEY (`id_salon_id`) REFERENCES `salon` (`id`),
  ADD CONSTRAINT `FK_C87435D03FC742D5` FOREIGN KEY (`id_barber_id`) REFERENCES `barber` (`id`),
  ADD CONSTRAINT `FK_C87435D079F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

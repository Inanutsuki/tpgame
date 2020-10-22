-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 22 oct. 2020 à 13:56
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_game`
--
CREATE DATABASE IF NOT EXISTS `tp_game` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tp_game`;

-- --------------------------------------------------------

--
-- Structure de la table `gamebadguy`
--

DROP TABLE IF EXISTS `gamebadguy`;
CREATE TABLE IF NOT EXISTS `gamebadguy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameBadGuy` int(11) NOT NULL,
  `damageBadGuy` int(11) NOT NULL DEFAULT '0',
  `experienceGiven` int(11) NOT NULL DEFAULT '0',
  `levelBadGuy` int(11) NOT NULL DEFAULT '0',
  `strengthBadGuy` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nameBadGuy` (`nameBadGuy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `gamecharacter`
--

DROP TABLE IF EXISTS `gamecharacter`;
CREATE TABLE IF NOT EXISTS `gamecharacter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameChar` varchar(25) NOT NULL,
  `classChar` varchar(255) DEFAULT NULL,
  `ability` int(11) NOT NULL DEFAULT '0',
  `damage` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `levelChar` int(11) NOT NULL DEFAULT '0',
  `strength` int(11) NOT NULL DEFAULT '0',
  `DPS` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nameChar` (`nameChar`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `gamecharacter`
--

INSERT INTO `gamecharacter` (`id`, `nameChar`, `classChar`, `ability`, `damage`, `experience`, `levelChar`, `strength`, `DPS`) VALUES
(433, 'bad guy 1', 'Warrior', 100, 17, 0, 7, 105, 354);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

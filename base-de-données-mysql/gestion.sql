-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 juin 2025 à 12:56
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion`
--
DROP DATABASE IF EXISTS `gestion`;
CREATE DATABASE IF NOT EXISTS `gestion`;
USE `gestion`;

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `identifiant` varchar(100) DEFAULT NULL,
  `numero_pv` varchar(100) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `code` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pays` varchar(10) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `identifiant` varchar(20) NOT NULL,
  `numero_pv` varchar(20) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bailleurs`
--

DROP TABLE IF EXISTS `bailleurs`;
CREATE TABLE IF NOT EXISTS `bailleurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pays` varchar(10) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `numero_pv` varchar(20) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1` (`id_personne`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int DEFAULT NULL,
  `id_agent` int NOT NULL,
  `matricule` text NOT NULL,
  `numero_propriete` text NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `Pays` varchar(50) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `identifiant` varchar(50) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demandes_estimation`
--

DROP TABLE IF EXISTS `demandes_estimation`;
CREATE TABLE IF NOT EXISTS `demandes_estimation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_bien` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `surface` int NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pieces` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `date_demande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('nouveau','en_cours','traite') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'nouveau',
  `email_contact` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telephone_contact` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_date_demande` (`date_demande`),
  KEY `idx_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `property_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_favorite` (`user_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `managers`
--

DROP TABLE IF EXISTS `managers`;
CREATE TABLE IF NOT EXISTS `managers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pays` varchar(10) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `identifiant` varchar(20) NOT NULL,
  `numero_pv` varchar(20) NOT NULL,
  `date_creation` datetime DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

DROP TABLE IF EXISTS `personnes`;
CREATE TABLE IF NOT EXISTS `personnes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricule` text NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `adresse` text,
  `identifiant` varchar(100) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proprietes`
--

DROP TABLE IF EXISTS `proprietes`;
CREATE TABLE IF NOT EXISTS `proprietes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identifiant` text NOT NULL,
  `code` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `utilisation` varchar(50) NOT NULL,
  `option_propriete` varchar(50) NOT NULL,
  `adresse` text NOT NULL,
  `ville` varchar(100) NOT NULL,
  `taille` decimal(10,2) NOT NULL,
  `prix` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `images` text NOT NULL,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(20) DEFAULT 'en_attente',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
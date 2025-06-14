-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 14 juin 2025 à 16:54
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Encodage
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `gestion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion`;

-- Table `administrateurs`
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `administrateurs` VALUES
(1, 1, 'createur', 'createur', 'createur@gmail.com', '+226', '52875041', 'createur', 'createur', '2025-06-14 00:00:00', 'createur');

-- Table `agents`
DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` varchar(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- Table `bailleurs`
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
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

-- Table `clients`
DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` int DEFAULT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4;

-- Table `managers`
DROP TABLE IF EXISTS `managers`;
CREATE TABLE IF NOT EXISTS `managers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_personne` varchar(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Table `personnes`
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Table `proprietes`
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
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4;

-- Table `messages`
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


COMMIT;

-- Encodage : retour
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

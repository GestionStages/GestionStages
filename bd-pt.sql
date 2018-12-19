-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 01 déc. 2018 à 16:31
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bd-pt`
--

-- --------------------------------------------------------

--
-- Structure de la table `associerclassespropositions`
--

DROP TABLE IF EXISTS `associerclassespropositions`;
CREATE TABLE IF NOT EXISTS `associerclassespropositions` (
  `codeProposition` int(11) NOT NULL,
  `codeClasse` int(11) NOT NULL,
  PRIMARY KEY (`codeProposition`,`codeClasse`),
  KEY `IDX_E93C30F3AB4411A` (`codeProposition`),
  KEY `IDX_E93C30F3EE464F70` (`codeClasse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `associerclassespropositions`
--

INSERT INTO `associerclassespropositions` (`codeProposition`, `codeClasse`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 2),
(3, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisescontact`
--

DROP TABLE IF EXISTS `associerentreprisescontact`;
CREATE TABLE IF NOT EXISTS `associerentreprisescontact` (
  `codeEntreprise` int(11) NOT NULL,
  `codeContact` int(11) NOT NULL,
  PRIMARY KEY (`codeEntreprise`,`codeContact`),
  KEY `IDX_7C4F034AA39D2095` (`codeEntreprise`),
  KEY `IDX_7C4F034A56A6085` (`codeContact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisesdomaine`
--

DROP TABLE IF EXISTS `associerentreprisesdomaine`;
CREATE TABLE IF NOT EXISTS `associerentreprisesdomaine` (
  `codeEntreprise` int(11) NOT NULL,
  `codeDomaine` int(11) NOT NULL,
  PRIMARY KEY (`codeEntreprise`,`codeDomaine`),
  KEY `IDX_4882EFBEA39D2095` (`codeEntreprise`),
  KEY `IDX_4882EFBE31A78C71` (`codeDomaine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `associerentreprisesdomaine`
--

INSERT INTO `associerentreprisesdomaine` (`codeEntreprise`, `codeDomaine`) VALUES
(1, 2),
(1, 3),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `associertechnologiespropositions`
--

DROP TABLE IF EXISTS `associertechnologiespropositions`;
CREATE TABLE IF NOT EXISTS `associertechnologiespropositions` (
  `codeProposition` int(11) NOT NULL,
  `codeTechnologie` int(11) NOT NULL,
  PRIMARY KEY (`codeProposition`,`codeTechnologie`),
  KEY `IDX_9FB189D2AB4411A` (`codeProposition`),
  KEY `IDX_9FB189D260F8B43D` (`codeTechnologie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `associertechnologiespropositions`
--

INSERT INTO `associertechnologiespropositions` (`codeProposition`, `codeTechnologie`) VALUES
(1, 1),
(1, 3),
(1, 6),
(2, 2),
(2, 8),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `nomClasse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `dateDebStage` date DEFAULT NULL,
  `dateFinStage` date DEFAULT NULL,
  `codeClasse` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeClasse`),
  UNIQUE KEY `UNIQ_2ED7EC5A8EBCAA9` (`nomClasse`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`nomClasse`, `description`, `dateDebStage`, `dateFinStage`, `codeClasse`) VALUES
('LP-APIDAE', 'E-BUSINESS / WEB', '2019-01-17', '2019-05-15', 1),
('LP-ACPI', 'ASSISTANT CHEF PROJET INFORMATIQUE', NULL, NULL, 2),
('LP-PSGI', 'SYSTÈMES D’INFORMATION ET GESTION DE DONNÉES', '2019-03-16', '2019-06-12', 4);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `nomContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenomContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `posteContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailContact` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `telContact` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `codeContact` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeContact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `domaineactivite`
--

DROP TABLE IF EXISTS `domaineactivite`;
CREATE TABLE IF NOT EXISTS `domaineactivite` (
  `nomDomaine` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codeDomaine` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeDomaine`),
  UNIQUE KEY `UNIQ_10E45016CEEE4B84` (`nomDomaine`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `domaineactivite`
--

INSERT INTO `domaineactivite` (`nomDomaine`, `codeDomaine`) VALUES
('Autre', 4),
('Comptablité', 2),
('Jeux Vidéo', 1),
('Social', 5),
('Streaming', 3);

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE IF NOT EXISTS `entreprises` (
  `nomEntreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresseEntreprise` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `villeEntreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codePostalEntreprise` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `telEntreprise` char(14) COLLATE utf8_unicode_ci NOT NULL,
  `blacklister` tinyint(1) NOT NULL DEFAULT '0',
  `codeEntreprise` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeEntreprise`),
  UNIQUE KEY `UNIQ_56B1B7A99B2929EC` (`nomEntreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`nomEntreprise`, `adresseEntreprise`, `villeEntreprise`, `codePostalEntreprise`, `telEntreprise`, `blacklister`, `codeEntreprise`) VALUES
('ToHero', '1 rue Emile Ain', 'Montpellier', '34090', '0642520665', 1, 1),
('CGI', '8 rue Georges Freche', 'Montpellier', '34096', '0658653145', 0, 4),
('Kaliop', '7 rue Ponpidou', 'Montpellier', '34090', '04.95.45.65.23', 0, 5),
('Cap Gemini', '25 avenue polichon', 'Montpellier', '34090', '0685956535', 0, 6),
('Le jardin des chats', '60 chemin de pergue', 'Aubais', '30250', '0466382867', 0, 7),
('Générale du Solaire', '230 rue Saint exupéry', 'Mauguio', '34130', '0411626352', 0, 8),
('L\'Atelier de la Peluche', '8 rue Jacques d\'Aragon', 'Montpellier', '34000', '0964284857', 0, 9),
('DAI SARL', 'Non fournie', 'Saint Gély du Fesc', '34981', '0695707639', 0, 10),
('Groupe SOTHYS', 'Non fournie', 'Brive', '19100', '0555174500', 0, 11),
('INRA', '2 place Pierre Viala', 'Montpellier', '34060', '0700000000', 0, 12),
('ACELYS', 'Pole Eureka 418 rue du Mas Verchant', 'Montpellier', '34000', '0467155015', 0, 13);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `nomEtat` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `codeEtat` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`nomEtat`, `codeEtat`) VALUES
('En attente de validation', 1),
('Validé', 2),
('Affecté', 3),
('Archivé', 4),
('Refusé', 5);

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `urlFichier` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `codeFichier` int(11) NOT NULL AUTO_INCREMENT,
  `codeProposition` int(11) DEFAULT NULL,
  PRIMARY KEY (`codeFichier`),
  KEY `fk_codePropositionFichier` (`codeProposition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

DROP TABLE IF EXISTS `propositions`;
CREATE TABLE IF NOT EXISTS `propositions` (
  `titreProposition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionProposition` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateAjout` datetime NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `codeProposition` int(11) NOT NULL AUTO_INCREMENT,
  `codeEntreprise` int(11) NOT NULL,
  `codeEtat` int(11) DEFAULT NULL,
  `file` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codeProposition`),
  KEY `fk_codeEntreprise` (`codeEntreprise`),
  KEY `fk_codeEtat` (`codeEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `propositions`
--

INSERT INTO `propositions` (`titreProposition`, `descriptionProposition`, `dateAjout`, `commentaire`, `codeProposition`, `codeEntreprise`, `codeEtat`, `file`) VALUES
('Développement WEB (JS)', 'Vous serez amenez a développer une application WEB dans une équipe de 4 développeur.', '2018-11-26 15:41:31', NULL, 1, 4, 4, NULL),
('Développement C++ / JAVA', 'Vous devrez développer une application en C permettant de mettre les énergies renouvelables en avant', '2018-11-26 15:42:31', NULL, 2, 5, 2, NULL),
('Développement JAVA / JS', 'Votre tâche sera de mettre en avant la puissance de cette outils par diverses statistiques de notre entreprise.', '2018-11-26 15:43:43', NULL, 3, 1, 5, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `technologies`
--

DROP TABLE IF EXISTS `technologies`;
CREATE TABLE IF NOT EXISTS `technologies` (
  `nomTechnologie` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `codeTechnologie` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`codeTechnologie`),
  UNIQUE KEY `UNIQ_4CCBFB184919C9AC` (`nomTechnologie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `technologies`
--

INSERT INTO `technologies` (`nomTechnologie`, `codeTechnologie`) VALUES
('BOOTSTRAP', 6),
('C#', 7),
('C++', 8),
('JAVA', 2),
('JAVASCRIPT', 3),
('PHP', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `associerclassespropositions`
--
ALTER TABLE `associerclassespropositions`
  ADD CONSTRAINT `FK_E93C30F3AB4411A` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`),
  ADD CONSTRAINT `FK_E93C30F3EE464F70` FOREIGN KEY (`codeClasse`) REFERENCES `classes` (`codeClasse`);

--
-- Contraintes pour la table `associerentreprisescontact`
--
ALTER TABLE `associerentreprisescontact`
  ADD CONSTRAINT `FK_7C4F034A56A6085` FOREIGN KEY (`codeContact`) REFERENCES `contacts` (`codeContact`),
  ADD CONSTRAINT `FK_7C4F034AA39D2095` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`);

--
-- Contraintes pour la table `associerentreprisesdomaine`
--
ALTER TABLE `associerentreprisesdomaine`
  ADD CONSTRAINT `FK_4882EFBE31A78C71` FOREIGN KEY (`codeDomaine`) REFERENCES `domaineactivite` (`codeDomaine`),
  ADD CONSTRAINT `FK_4882EFBEA39D2095` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`);

--
-- Contraintes pour la table `associertechnologiespropositions`
--
ALTER TABLE `associertechnologiespropositions`
  ADD CONSTRAINT `FK_9FB189D260F8B43D` FOREIGN KEY (`codeTechnologie`) REFERENCES `technologies` (`codeTechnologie`),
  ADD CONSTRAINT `FK_9FB189D2AB4411A` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`);

--
-- Contraintes pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `FK_969DB4ABAB4411A` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`);

--
-- Contraintes pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD CONSTRAINT `FK_E9AB028650B3760C` FOREIGN KEY (`codeEtat`) REFERENCES `etat` (`codeEtat`),
  ADD CONSTRAINT `FK_E9AB0286A39D2095` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Sam 24 Novembre 2018 à 22:50
-- Version du serveur :  10.1.26-MariaDB-0+deb9u1
-- Version de PHP :  7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `associerclassespropositions`
--

DROP TABLE IF EXISTS `associerclassespropositions`;
CREATE TABLE `associerclassespropositions` (
  `codeProposition` int(11) NOT NULL,
  `codeClasse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `associerclassespropositions`
--

INSERT INTO `associerclassespropositions` (`codeProposition`, `codeClasse`) VALUES
(1, 1),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(8, 1),
(9, 1),
(9, 2),
(11, 1);

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisescontact`
--

DROP TABLE IF EXISTS `associerentreprisescontact`;
CREATE TABLE `associerentreprisescontact` (
  `codeEntreprise` int(11) NOT NULL,
  `codeContact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `associerentreprisescontact`
--

INSERT INTO `associerentreprisescontact` (`codeEntreprise`, `codeContact`) VALUES
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisesdomaine`
--

DROP TABLE IF EXISTS `associerentreprisesdomaine`;
CREATE TABLE `associerentreprisesdomaine` (
  `codeEntreprise` int(11) NOT NULL,
  `codeDomaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `associerentreprisesdomaine`
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
CREATE TABLE `associertechnologiespropositions` (
  `codeTechnologie` int(11) NOT NULL,
  `codeProposition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `associertechnologiespropositions`
--

INSERT INTO `associertechnologiespropositions` (`codeTechnologie`, `codeProposition`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `codeClasse` int(11) NOT NULL,
  `nomClasse` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `classes`
--

INSERT INTO `classes` (`codeClasse`, `nomClasse`, `description`) VALUES
(1, 'LP-APIDAE', 'E-business (WEB)'),
(2, 'LP-ACPI', 'Assistant chef projet informatique');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `codeContact` int(11) NOT NULL,
  `nomContact` varchar(30) NOT NULL,
  `prenomContact` varchar(30) NOT NULL,
  `mailContact` varchar(30) NOT NULL,
  `telContact` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `contacts`
--

INSERT INTO `contacts` (`codeContact`, `nomContact`, `prenomContact`, `mailContact`, `telContact`) VALUES
(3, 'toto', 'titi', 'toto@yo.com', '0204050607'),
(4, 'tata', 'titi', 'titi@gmail.com', '0658595260');

-- --------------------------------------------------------

--
-- Structure de la table `domaineactivite`
--

DROP TABLE IF EXISTS `domaineactivite`;
CREATE TABLE `domaineactivite` (
  `codeDomaine` int(11) NOT NULL,
  `nomDomaine` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `domaineactivite`
--

INSERT INTO `domaineactivite` (`codeDomaine`, `nomDomaine`) VALUES
(1, 'Jeux Vidéo'),
(2, 'Comptabilité'),
(3, 'Streaming'),
(4, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

DROP TABLE IF EXISTS `entreprises`;
CREATE TABLE `entreprises` (
  `codeEntreprise` int(11) NOT NULL,
  `nomEntreprise` varchar(30) NOT NULL,
  `adresseEntreprise` varchar(60) NOT NULL,
  `villeEntreprise` varchar(30) NOT NULL,
  `codePostalEntreprise` int(5) NOT NULL,
  `telEntreprise` char(14) NOT NULL,
  `blacklister` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `entreprises`
--

INSERT INTO `entreprises` (`codeEntreprise`, `nomEntreprise`, `adresseEntreprise`, `villeEntreprise`, `codePostalEntreprise`, `telEntreprise`, `blacklister`) VALUES
(1, 'ToHero', '1 rue Emile Ain', 'Montpellier', 34090, '0642520665', 0),
(4, 'CGI', '8 rue Georges Freche', 'Montpellier', 34096, '0658653145', 0),
(5, 'Kaliop', '7 rue Ponpidou', 'Montpellier', 34090, '04.95.45.65.23', 0),
(6, 'Cap Gemini', '25 avenue polichon', 'Montpellier', 34090, '0685956535', 0),
(7, 'Le jardin des chats', '60 chemin de pergue', 'Aubais', 30250, '0466382867', 0),
(8, 'Générale du Solaire', '230 rue Saint exupéry', 'Mauguio', 34130, '0411626352', 0),
(9, 'L\'Atelier de la Peluche', '8 rue Jacques d\'Aragon', 'Montpellier', 34000, '0964284857', 0),
(10, 'DAI SARL', 'Non fournie', 'Saint Gély du Fesc', 34981, '0695707639', 0),
(11, 'Groupe SOTHYS', 'Non fournie', 'Brive', 19100, '0555174500', 0),
(12, 'INRA', '2 place Pierre Viala', 'Montpellier', 34060, '0700000000', 0),
(13, 'ACELYS', 'Pole Eureka 418 rue du Mas Verchant', 'Montpellier', 34000, '0467155015', 0);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE `etat` (
  `codeEtat` int(11) NOT NULL,
  `nomEtat` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`codeEtat`, `nomEtat`) VALUES
(1, 'En attente de validation'),
(2, 'Validé'),
(3, 'Affecté'),
(4, 'Archivé'),
(5, 'Refusé');

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE `fichiers` (
  `codeFichier` int(11) NOT NULL,
  `urlFichier` varchar(500) NOT NULL,
  `codeProposition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `fichiers`
--

INSERT INTO `fichiers` (`codeFichier`, `urlFichier`, `codeProposition`) VALUES
(1, 'c:/documents/fichier.pdf', 1);

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

DROP TABLE IF EXISTS `propositions`;
CREATE TABLE `propositions` (
  `codeProposition` int(11) NOT NULL,
  `titreProposition` varchar(255) NOT NULL,
  `descriptionProposition` longtext NOT NULL,
  `dateAjout` datetime NOT NULL,
  `commentaire` longtext,
  `codeEntreprise` int(11) DEFAULT NULL,
  `codeEtat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `propositions`
--

INSERT INTO `propositions` (`codeProposition`, `titreProposition`, `descriptionProposition`, `dateAjout`, `commentaire`, `codeEntreprise`, `codeEtat`) VALUES
(1, 'Developpeur WEB - PHP/JAVA', 'Vous serez amenez à développer dans une équipe de développeur sur le site officiel de WAKANIM pour mettre à jour les fonctionnalités du site', '2018-10-22 00:00:00', NULL, 1, 5),
(2, 'Developpeur JAVA (Oracle)', 'Vous devrez développer dans une peite équipe un logiciel comptable en JAVA sous Oracle', '2018-10-23 00:00:00', NULL, 1, 1),
(3, 'test', 'bcdef', '2018-11-13 00:00:00', NULL, 5, 2),
(4, 'Application de réservations', 'Développement application web de gestion de réservations en HTML, CCS, PHP, JavaScript, Jquery', '2018-11-21 00:00:00', NULL, 7, 2),
(5, 'ERP Drupal 7', 'Développement d\'un ERP sous Drupal 7 (évolution CRM actuel)', '2018-11-21 00:00:00', NULL, 8, 2),
(6, 'Développement web', 'Dev web en PHP, HTML, CSS, JavaScript', '2018-11-21 00:00:00', NULL, 9, 2),
(7, 'Développement', 'Développer de nouveaux modules (applications web, communication avec des serveurs type Dossier Médical Personnel, sérialisation pharmaceutique, dossier pharmacie avec connexion SOAP et REST)', '2018-11-21 00:00:00', NULL, 10, 2),
(8, 'Développement web', '- Participer à l\'analyse du besoin décrit dans le cahier des charges fonctionnel ;\r\n- Proposer une ergonomie en rapport avec l’application existante ;\r\n- Identifier les solutions techniques adaptées dans le cadre de l’architecture technique existante ;', '2018-11-21 00:00:00', NULL, 11, 2),
(9, 'Système gestion produits', '- L’identification des besoins et l’étude des outils existants au sein de l’équipe.\r\n- Les spécifications d’un système interface / base de données.\r\n- Le développement du système.', '2018-11-21 00:00:00', NULL, 12, 2),
(10, 'Paramétrage Case Management', 'Vous devez implémenter une gestion de demandes entrantes, la gestion d’échanges d’informations entrantes et sortantes (dont des documents) entre l’émetteur de la demande et les acteurs en charge du traitement du dossier.', '2018-11-21 00:00:00', NULL, 1, 2),
(11, 'Testss', 'Une desciption test de 20 charactères', '2018-11-21 00:00:00', NULL, 4, 2),
(12, 'Développement WEB (JS)', 'Uneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', '2018-11-21 00:00:00', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `technologies`
--

DROP TABLE IF EXISTS `technologies`;
CREATE TABLE `technologies` (
  `codeTechnologie` int(11) NOT NULL,
  `nomTechnologie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `technologies`
--

INSERT INTO `technologies` (`codeTechnologie`, `nomTechnologie`) VALUES
(1, 'PHP'),
(2, 'JAVA'),
(3, 'JAVASCRIPT'),
(6, 'BOOTSTRAP'),
(7, 'C#'),
(8, 'C++');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `associerclassespropositions`
--
ALTER TABLE `associerclassespropositions`
  ADD PRIMARY KEY (`codeProposition`,`codeClasse`),
  ADD KEY `IDX_E93C30F3EE464F70` (`codeClasse`);

--
-- Index pour la table `associerentreprisescontact`
--
ALTER TABLE `associerentreprisescontact`
  ADD PRIMARY KEY (`codeEntreprise`,`codeContact`),
  ADD KEY `IDX_7C4F034A56A6085` (`codeContact`);

--
-- Index pour la table `associerentreprisesdomaine`
--
ALTER TABLE `associerentreprisesdomaine`
  ADD PRIMARY KEY (`codeEntreprise`,`codeDomaine`),
  ADD KEY `IDX_4882EFBE31A78C71` (`codeDomaine`);

--
-- Index pour la table `associertechnologiespropositions`
--
ALTER TABLE `associertechnologiespropositions`
  ADD PRIMARY KEY (`codeTechnologie`,`codeProposition`),
  ADD KEY `IDX_9FB189D2AB4411A` (`codeProposition`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`codeClasse`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`codeContact`);

--
-- Index pour la table `domaineactivite`
--
ALTER TABLE `domaineactivite`
  ADD PRIMARY KEY (`codeDomaine`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`codeEntreprise`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`codeEtat`);

--
-- Index pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`codeFichier`),
  ADD KEY `fk_codePropositionFichier` (`codeProposition`);

--
-- Index pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD PRIMARY KEY (`codeProposition`),
  ADD KEY `fk_codeEntreprise` (`codeEntreprise`),
  ADD KEY `fk_codeEtat` (`codeEtat`);

--
-- Index pour la table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`codeTechnologie`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `codeClasse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `codeContact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `domaineactivite`
--
ALTER TABLE `domaineactivite`
  MODIFY `codeDomaine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `codeEntreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `etat`
--
ALTER TABLE `etat`
  MODIFY `codeEtat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `codeFichier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `propositions`
--
ALTER TABLE `propositions`
  MODIFY `codeProposition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `codeTechnologie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `associerclassespropositions`
--
ALTER TABLE `associerclassespropositions`
  ADD CONSTRAINT `fk_classesPropositions` FOREIGN KEY (`codeClasse`) REFERENCES `classes` (`codeClasse`),
  ADD CONSTRAINT `fk_propositionsClasses` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`);

--
-- Contraintes pour la table `associerentreprisescontact`
--
ALTER TABLE `associerentreprisescontact`
  ADD CONSTRAINT `fk_codeContactEntreprise` FOREIGN KEY (`codeContact`) REFERENCES `contacts` (`codeContact`),
  ADD CONSTRAINT `fk_codeEntrepriseContact` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`);

--
-- Contraintes pour la table `associerentreprisesdomaine`
--
ALTER TABLE `associerentreprisesdomaine`
  ADD CONSTRAINT `fk_codeDomaineEntreprise` FOREIGN KEY (`codeDomaine`) REFERENCES `domaineactivite` (`codeDomaine`),
  ADD CONSTRAINT `fk_codeEntrepriseDomaine` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`);

--
-- Contraintes pour la table `associertechnologiespropositions`
--
ALTER TABLE `associertechnologiespropositions`
  ADD CONSTRAINT `fk_codePropositionTechnologie` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`),
  ADD CONSTRAINT `fk_codeTechnologieProposition` FOREIGN KEY (`codeTechnologie`) REFERENCES `technologies` (`codeTechnologie`);

--
-- Contraintes pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `fk_codePropositionFichier` FOREIGN KEY (`codeProposition`) REFERENCES `propositions` (`codeProposition`);

--
-- Contraintes pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD CONSTRAINT `fk_codeEntreprise` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`),
  ADD CONSTRAINT `fk_codeEtat` FOREIGN KEY (`codeEtat`) REFERENCES `etat` (`codeEtat`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
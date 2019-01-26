-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le :  Dim 06 jan. 2019 à 18:48
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `iut_stages`
--

-- --------------------------------------------------------

--
-- Structure de la table `associerclassespropositions`
--

CREATE TABLE `associerclassespropositions` (
  `codeProposition` int(11) NOT NULL,
  `codeClasse` int(11) NOT NULL
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
(3, 4),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisescontact`
--

CREATE TABLE `associerentreprisescontact` (
  `codeEntreprise` int(11) NOT NULL,
  `codeContact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `associerentreprisescontact`
--

INSERT INTO `associerentreprisescontact` (`codeEntreprise`, `codeContact`) VALUES
(7, 1),
(8, 2),
(9, 3),
(10, 4),
(11, 5),
(12, 6);

-- --------------------------------------------------------

--
-- Structure de la table `associerentreprisesdomaine`
--

CREATE TABLE `associerentreprisesdomaine` (
  `codeEntreprise` int(11) NOT NULL,
  `codeDomaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `associerentreprisesdomaine`
--

INSERT INTO `associerentreprisesdomaine` (`codeEntreprise`, `codeDomaine`) VALUES
(1, 2),
(1, 3),
(5, 2),
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

CREATE TABLE `associertechnologiespropositions` (
  `codeProposition` int(11) NOT NULL,
  `codeTechnologie` int(11) NOT NULL
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
(3, 3),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `nomClasse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `dateDebStage` date DEFAULT NULL,
  `dateFinStage` date DEFAULT NULL,
  `codeClasse` int(11) NOT NULL,
  `codeGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`nomClasse`, `description`, `dateDebStage`, `dateFinStage`, `codeClasse`, `codeGroupe`) VALUES
('LP-APIDAE', 'E-BUSINESS / WEB', '2019-01-17', '2019-05-15', 1, 4),
('LP-ACPI', 'ASSISTANT CHEF PROJET INFORMATIQUE', NULL, NULL, 2, 4),
('LP-PSGI', 'SYSTÈMES D’INFORMATION ET GESTION DE DONNÉES', '2019-03-16', '2019-06-12', 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `nomContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenomContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `posteContact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailContact` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `telContact` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `codeContact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`nomContact`, `prenomContact`, `posteContact`, `mailContact`, `telContact`, `codeContact`) VALUES
('Zafrilla', 'Arnaud', 'POSTE', 'a.zafrilla@lejardindeschats.fr', '0466382867', 1),
('Succo', 'Romain', 'POSTE', 'romain.succo@gdsolaire.com', '0411626352', 2),
('Valette', 'Jérome', 'POSTE', 'jerome.valette@paraty-peluche.fr', '0964284857', 3),
('Archambault', 'Emanuel', 'POSTE', 'archambault@dai.fr', '0695707639', 4),
('Durth', 'Sandra', 'POSTE', 'sandra.durth@sothys.net', '0555174500', 5),
('Buche', 'Patrice', 'POSTE', 'patrice.buche@inra.fr', '0123456789', 6);

-- --------------------------------------------------------

--
-- Structure de la table `domaineactivite`
--

CREATE TABLE `domaineactivite` (
  `nomDomaine` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codeDomaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `entreprises` (
  `nomEntreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresseEntreprise` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `villeEntreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codePostalEntreprise` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `telEntreprise` char(14) COLLATE utf8_unicode_ci NOT NULL,
  `blacklister` tinyint(1) NOT NULL DEFAULT '0',
  `codeEntreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`nomEntreprise`, `adresseEntreprise`, `villeEntreprise`, `codePostalEntreprise`, `telEntreprise`, `blacklister`, `codeEntreprise`) VALUES
('ToHero', '1 rue Emile Ain', 'Montpellier', '34090', '0642520665', 0, 1),
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

CREATE TABLE `etat` (
  `nomEtat` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `codeEtat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `nomEtudiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenomEtudiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailEtudiant` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `telEtudiant` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `codeClasse` int(11) NOT NULL,
  `userEtudiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numEtudiant` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `addrEtudiant` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `dateEtudiant` date NOT NULL,
  `sexeEtudiant` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `passEtudiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nomEtudiant`, `prenomEtudiant`, `mailEtudiant`, `telEtudiant`, `codeClasse`, `userEtudiant`, `numEtudiant`, `addrEtudiant`, `dateEtudiant`, `sexeEtudiant`, `passEtudiant`) VALUES
(1, 'Zétofrais', 'Mélanie', 'melanie.zetofrais@iutmtp.xp', '0123456789', 1, 'zetofraism', '00000001', 'Adresse de Zétofrais Mélanie', '2018-12-20', 'f', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.'),
(2, 'Bricot', 'Judas', 'judas.bricot@iutmtp.xp', '0987654321', 1, 'bricotj', '00000027', 'Adresse de Judas Bricot', '2018-12-20', 'o', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.'),
(3, 'Zeblouse', 'Agathe', 'agathe.zeblouse@iutmtp.xp', '0123456789', 4, 'zeblousea', '00000003', 'Adresse de Zeblouse Agathe', '2018-12-20', 'h', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.'),
(4, 'Ouzy', 'Jacques', 'jacques.ouzy@iutmtp.xp', '0123456789', 1, 'ouzyj', '00000004', 'Adresse de Ouzy Jacques', '2018-12-20', 'h', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.'),
(5, 'Tarembois', 'Guy', 'guy.tarembois@iutmtp.xp', '0123456789', 2, 'taremboisg', '00000005', 'Adresse de Tarembois Guy', '2018-12-20', 'h', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.'),
(6, 'Terrieur', 'Alex', 'alex.terrieur@iutmtp.xp', '0123456789', 4, 'terrieura', '00000006', 'Adresse de Terrieur Alex', '2018-12-20', 'h', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_ldap`
--

CREATE TABLE `groupes_ldap` (
  `ldapSection` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isLicence` tinyint(1) NOT NULL,
  `codeGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupes_ldap`
--

INSERT INTO `groupes_ldap` (`ldapSection`, `isLicence`, `codeGroupe`) VALUES
('Ann1', 0, 1),
('Ann2', 0, 2),
('As', 0, 3),
('Licence', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `id` int(11) NOT NULL,
  `nomProf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenomProf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailProf` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `telProf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userProf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passProf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roleProf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `nomProf`, `prenomProf`, `mailProf`, `telProf`, `userProf`, `passProf`, `roleProf`) VALUES
(1, 'Palleja', 'Xavier', 'xavier.palleja@umontpellier.fr', '0123456789', 'pallejax', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 1),
(2, 'Sperge', 'Judas', 'judas.sperge@iutmtp.xp', '0123456789', 'spergej', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 1),
(3, 'Deuf', 'John', 'john.deuf@iutmtp.xp', '0123456789', 'deufj', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 1),
(4, 'Fowler', 'Martin', 'martin.fowler@agile.xp', '0123456789', 'fowlerm', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 1),
(5, 'Palleja', 'Nathalie', 'nathalie.palleja@umontpellier.fr', '0123456789', 'pallejan', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 2),
(6, 'Garcia', 'Francis', 'francis.garcia@umontpellier.fr', '0123456789', 'graciaf', '$2y$10$wFwQML3/NWwFBI93IhlGyeLkUfYNP5q95T3Xq7/00gCDasho6FFO.', 3);

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

CREATE TABLE `propositions` (
  `titreProposition` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionProposition` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateAjout` datetime NOT NULL,
  `commentaire` longtext COLLATE utf8_unicode_ci,
  `codeProposition` int(11) NOT NULL,
  `codeEntreprise` int(11) NOT NULL,
  `codeEtat` int(11) DEFAULT NULL,
  `file` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codeEtudiant` int(11) DEFAULT NULL,
  `codeProfesseur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `propositions`
--

INSERT INTO `propositions` (`titreProposition`, `descriptionProposition`, `dateAjout`, `commentaire`, `codeProposition`, `codeEntreprise`, `codeEtat`, `file`, `codeEtudiant`, `codeProfesseur`) VALUES
('Développement WEB (JS)', 'Vous serez amenez a développer une application WEB dans une équipe de 4 développeur.', '2018-11-26 15:41:31', NULL, 1, 4, 4, NULL, NULL, NULL),
('Développement C++ / JAVA', 'Vous devrez développer une application en C permettant de mettre les énergies renouvelables en avant', '2018-11-26 15:42:31', NULL, 2, 5, 2, NULL, 1, 4),
('Développement JAVA / JS', 'Votre tâche sera de mettre en avant la puissance de cette outils par diverses statistiques de notre entreprise.', '2018-11-26 15:43:43', NULL, 3, 1, 4, NULL, NULL, NULL),
('Nouvelle prop', 'Proposition', '2018-12-20 12:07:13', NULL, 4, 6, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `roles_prof`
--

CREATE TABLE `roles_prof` (
  `titreRole` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomRole` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codeRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `roles_prof`
--

INSERT INTO `roles_prof` (`titreRole`, `nomRole`, `codeRole`) VALUES
('Professeur', NULL, 1),
('Responsable des stages', 'ROLE_RESPSTAGES', 2),
('Chef de département', 'ROLE_CHEFDEP', 3);

-- --------------------------------------------------------

--
-- Structure de la table `technologies`
--

CREATE TABLE `technologies` (
  `nomTechnologie` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `codeTechnologie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Index pour les tables déchargées
--

--
-- Index pour la table `associerclassespropositions`
--
ALTER TABLE `associerclassespropositions`
  ADD PRIMARY KEY (`codeProposition`,`codeClasse`),
  ADD KEY `IDX_E93C30F3AB4411A` (`codeProposition`),
  ADD KEY `IDX_E93C30F3EE464F70` (`codeClasse`);

--
-- Index pour la table `associerentreprisescontact`
--
ALTER TABLE `associerentreprisescontact`
  ADD PRIMARY KEY (`codeEntreprise`,`codeContact`),
  ADD KEY `IDX_7C4F034AA39D2095` (`codeEntreprise`),
  ADD KEY `IDX_7C4F034A56A6085` (`codeContact`);

--
-- Index pour la table `associerentreprisesdomaine`
--
ALTER TABLE `associerentreprisesdomaine`
  ADD PRIMARY KEY (`codeEntreprise`,`codeDomaine`),
  ADD KEY `IDX_4882EFBEA39D2095` (`codeEntreprise`),
  ADD KEY `IDX_4882EFBE31A78C71` (`codeDomaine`);

--
-- Index pour la table `associertechnologiespropositions`
--
ALTER TABLE `associertechnologiespropositions`
  ADD PRIMARY KEY (`codeProposition`,`codeTechnologie`),
  ADD KEY `IDX_9FB189D2AB4411A` (`codeProposition`),
  ADD KEY `IDX_9FB189D260F8B43D` (`codeTechnologie`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`codeClasse`),
  ADD UNIQUE KEY `UNIQ_2ED7EC5A8EBCAA9` (`nomClasse`),
  ADD KEY `IDX_2ED7EC565787CC7` (`codeGroupe`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`codeContact`);

--
-- Index pour la table `domaineactivite`
--
ALTER TABLE `domaineactivite`
  ADD PRIMARY KEY (`codeDomaine`),
  ADD UNIQUE KEY `UNIQ_10E45016CEEE4B84` (`nomDomaine`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`codeEntreprise`),
  ADD UNIQUE KEY `UNIQ_56B1B7A99B2929EC` (`nomEntreprise`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`codeEtat`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_717E22E3A44DBFC2` (`userEtudiant`),
  ADD KEY `IDX_717E22E3EE464F70` (`codeClasse`);

--
-- Index pour la table `groupes_ldap`
--
ALTER TABLE `groupes_ldap`
  ADD PRIMARY KEY (`codeGroupe`),
  ADD UNIQUE KEY `UNIQ_4B6FA48771AF8963` (`ldapSection`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_17A552995DF5A7F4` (`userProf`),
  ADD KEY `IDX_17A55299281420D` (`roleProf`);

--
-- Index pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD PRIMARY KEY (`codeProposition`),
  ADD UNIQUE KEY `UNIQ_E9AB0286C4E7E554` (`codeEtudiant`),
  ADD KEY `fk_codeEntreprise` (`codeEntreprise`),
  ADD KEY `fk_codeEtat` (`codeEtat`),
  ADD KEY `IDX_E9AB0286B921886C` (`codeProfesseur`);

--
-- Index pour la table `roles_prof`
--
ALTER TABLE `roles_prof`
  ADD PRIMARY KEY (`codeRole`);

--
-- Index pour la table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`codeTechnologie`),
  ADD UNIQUE KEY `UNIQ_4CCBFB184919C9AC` (`nomTechnologie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `codeClasse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `codeContact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `domaineactivite`
--
ALTER TABLE `domaineactivite`
  MODIFY `codeDomaine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `groupes_ldap`
--
ALTER TABLE `groupes_ldap`
  MODIFY `codeGroupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `professeur`
--
ALTER TABLE `professeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `propositions`
--
ALTER TABLE `propositions`
  MODIFY `codeProposition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `roles_prof`
--
ALTER TABLE `roles_prof`
  MODIFY `codeRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `codeTechnologie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `FK_2ED7EC565787CC7` FOREIGN KEY (`codeGroupe`) REFERENCES `groupes_ldap` (`codeGroupe`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_717E22E3EE464F70` FOREIGN KEY (`codeClasse`) REFERENCES `classes` (`codeClasse`);

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `FK_17A55299281420D` FOREIGN KEY (`roleProf`) REFERENCES `roles_prof` (`codeRole`);

--
-- Contraintes pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD CONSTRAINT `FK_E9AB028650B3760C` FOREIGN KEY (`codeEtat`) REFERENCES `etat` (`codeEtat`),
  ADD CONSTRAINT `FK_E9AB0286A39D2095` FOREIGN KEY (`codeEntreprise`) REFERENCES `entreprises` (`codeEntreprise`),
  ADD CONSTRAINT `FK_E9AB0286B921886C` FOREIGN KEY (`codeProfesseur`) REFERENCES `professeur` (`id`),
  ADD CONSTRAINT `FK_E9AB0286C4E7E554` FOREIGN KEY (`codeEtudiant`) REFERENCES `etudiant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
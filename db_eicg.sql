-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 03 juil. 2026 à 02:08
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_eicg`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessoires`
--

DROP TABLE IF EXISTS `accessoires`;
CREATE TABLE IF NOT EXISTS `accessoires` (
  `id_accessoire` int NOT NULL AUTO_INCREMENT,
  `code_accessoire` varchar(50) NOT NULL,
  `libelle_accessoire` varchar(255) NOT NULL,
  `statut_accessoire` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at_accessoire` timestamp NOT NULL,
  `etablissement_code` varchar(50) DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_accessoire`),
  UNIQUE KEY `code_accessoire` (`code_accessoire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `accessoire_inscription`
--

DROP TABLE IF EXISTS `accessoire_inscription`;
CREATE TABLE IF NOT EXISTS `accessoire_inscription` (
  `id_accessoire_inscription` int NOT NULL AUTO_INCREMENT,
  `code_accessoire_inscription` varchar(50) NOT NULL,
  `inscription_code` varchar(50) NOT NULL,
  `accessoire_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `statut_accessoire_inscription` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at_accessoire_inscription` timestamp NOT NULL,
  `etablissement_code` varchar(50) DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_accessoire_inscription`),
  UNIQUE KEY `code_accessoire_inscription` (`code_accessoire_inscription`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

DROP TABLE IF EXISTS `annees`;
CREATE TABLE IF NOT EXISTS `annees` (
  `id_annee` int NOT NULL AUTO_INCREMENT,
  `libelle_annee` varchar(50) NOT NULL,
  `date_debut_annee` date NOT NULL,
  `date_fin_annee` date NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `created_at_annee` datetime NOT NULL,
  `updated_at_annee` datetime DEFAULT NULL,
  `statut_annee` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_annee`),
  UNIQUE KEY `uq_annee_libelle` (`libelle_annee`,`etablissement_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id_classe` int NOT NULL AUTO_INCREMENT,
  `code_classe` varchar(50) NOT NULL,
  `libelle_classe` varchar(150) NOT NULL,
  `capacite_max_classe` int DEFAULT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `niveau_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `statut_classe` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at_classe` datetime NOT NULL,
  `updated_at_classe` datetime DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_classe`),
  UNIQUE KEY `code_classe` (`code_classe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cycles`
--

DROP TABLE IF EXISTS `cycles`;
CREATE TABLE IF NOT EXISTS `cycles` (
  `id_cycle` int NOT NULL AUTO_INCREMENT,
  `code_cycle` varchar(50) NOT NULL,
  `libelle_cycle` varchar(100) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `created_at_cycle` datetime NOT NULL,
  `updated_at_cycle` datetime DEFAULT NULL,
  `statut_cycle` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cycle`),
  UNIQUE KEY `code_cycle` (`code_cycle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id_document` int NOT NULL AUTO_INCREMENT,
  `libelle_document` varchar(100) NOT NULL,
  `lien_document` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `filiere_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `niveaux_code` varchar(50) NOT NULL,
  `etablisement_code` varchar(100) NOT NULL,
  `statut_document` enum('actif','innactif','','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dossier_etudiant`
--

DROP TABLE IF EXISTS `dossier_etudiant`;
CREATE TABLE IF NOT EXISTS `dossier_etudiant` (
  `id_dossier_etudiant` int NOT NULL AUTO_INCREMENT,
  `code_dossier_etudiant` varchar(50) NOT NULL,
  `etudiant_code` varchar(50) NOT NULL,
  `libelle_dossier` varchar(255) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `created_at_dossier_etudiant` datetime NOT NULL,
  `updated_at_dossier_etudiant` datetime DEFAULT NULL,
  `user_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id_dossier_etudiant`),
  UNIQUE KEY `code_dossier_etudiant` (`code_dossier_etudiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emplois_temps`
--

DROP TABLE IF EXISTS `emplois_temps`;
CREATE TABLE IF NOT EXISTS `emplois_temps` (
  `id_emploi` int NOT NULL AUTO_INCREMENT,
  `code_emploi` varchar(50) NOT NULL,
  `classe_code` varchar(50) NOT NULL,
  `matiere_code` varchar(50) NOT NULL,
  `enseignant_code` varchar(50) NOT NULL,
  `salle_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `jour` enum('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `created_at_emploi` datetime DEFAULT NULL,
  `updated_at_emploi` datetime DEFAULT NULL,
  `statut_emploi` enum('actif','inactif') DEFAULT 'actif',
  PRIMARY KEY (`id_emploi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

DROP TABLE IF EXISTS `enseignants`;
CREATE TABLE IF NOT EXISTS `enseignants` (
  `id_enseignant` int NOT NULL AUTO_INCREMENT,
  `code_enseignant` varchar(50) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `nom_enseignant` varchar(200) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `telephone` varchar(30) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `photo_enseignant` varchar(100) DEFAULT NULL,
  `statut_enseignant` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `password_enseignant` varchar(255) DEFAULT NULL,
  `created_at_enseignant` datetime NOT NULL,
  `updated_at_enseignant` datetime DEFAULT NULL,
  `user_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id_enseignant`),
  UNIQUE KEY `code_enseignant` (`code_enseignant`),
  UNIQUE KEY `matricule` (`matricule`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant_matiere`
--

DROP TABLE IF EXISTS `enseignant_matiere`;
CREATE TABLE IF NOT EXISTS `enseignant_matiere` (
  `id_enseignant_matiere` int NOT NULL AUTO_INCREMENT,
  `enseignant_code` varchar(50) NOT NULL,
  `matiere_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `created_at_enseignant_matiere` datetime NOT NULL,
  `updated_at_enseignant_matiere` datetime DEFAULT NULL,
  `statut_enseignant_matiere` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_enseignant_matiere`),
  UNIQUE KEY `uq_enseignant_matiere` (`enseignant_code`,`matiere_code`,`etablissement_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

DROP TABLE IF EXISTS `etablissements`;
CREATE TABLE IF NOT EXISTS `etablissements` (
  `id_etablissement` int NOT NULL AUTO_INCREMENT,
  `code_etablissement` varchar(50) NOT NULL,
  `libelle_etablissement` varchar(200) NOT NULL,
  `adresse_etablissement` text,
  `telephone_etablissement` varchar(30) DEFAULT NULL,
  `telephone_etablissement2` varchar(30) DEFAULT NULL,
  `email_etablissement` varchar(150) DEFAULT NULL,
  `logo_etablissement` varchar(500) DEFAULT NULL,
  `slogan_etablissement` varchar(200) DEFAULT NULL,
  `created_at_etablissement` datetime NOT NULL,
  `updated_at_etablissement` datetime DEFAULT NULL,
  `statut_etablissement` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_etablissement`),
  UNIQUE KEY `code_etablissement` (`code_etablissement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiant` int NOT NULL AUTO_INCREMENT,
  `code_etudiant` varchar(50) NOT NULL,
  `matricule_etudiant` varchar(50) NOT NULL,
  `nom_etudiant` varchar(100) NOT NULL,
  `prenom_etudiant` varchar(255) NOT NULL,
  `date_naissance_etudiant` date DEFAULT NULL,
  `lieu_naissance_etudiant` varchar(255) DEFAULT NULL,
  `sexe_etudiant` varchar(25) DEFAULT NULL,
  `nationalite_etudiant` varchar(100) DEFAULT NULL,
  `lieu_residence_etudiant` text,
  `telephone_etudiant` varchar(50) DEFAULT NULL,
  `email_etudiant` varchar(150) DEFAULT NULL,
  `photo_etudiant` varchar(255) DEFAULT NULL,
  `password_etudiant` varchar(255) DEFAULT NULL,
  `numero_cni` varchar(50) DEFAULT NULL,
  `statut_etudiant` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at_etudiant` datetime NOT NULL,
  `updated_at_etudiant` datetime DEFAULT NULL,
  `user_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id_etudiant`),
  UNIQUE KEY `code_etudiant` (`code_etudiant`),
  UNIQUE KEY `matricule_etudiant` (`matricule_etudiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id_evenement` int NOT NULL AUTO_INCREMENT,
  `titre_evenement` varchar(255) NOT NULL,
  `image_evenement` varchar(255) DEFAULT NULL,
  `description_evenement` text,
  `is_principal_evenement` tinyint(1) DEFAULT '0',
  `date_creation_evenement` datetime DEFAULT NULL,
  `date_modification_evenement` datetime DEFAULT NULL,
  `statut_evenement` enum('actif','innactif') DEFAULT 'actif',
  PRIMARY KEY (`id_evenement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
CREATE TABLE IF NOT EXISTS `filieres` (
  `id_filiere` int NOT NULL AUTO_INCREMENT,
  `code_filiere` varchar(50) NOT NULL,
  `libelle_filiere` varchar(150) NOT NULL,
  `description_filiere` text,
  `etablissement_code` varchar(50) NOT NULL,
  `cycle_code` varchar(50) NOT NULL,
  `created_at_filiere` datetime NOT NULL,
  `updated_at_filiere` datetime DEFAULT NULL,
  `statut_filiere` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_filiere`),
  UNIQUE KEY `code_filiere` (`code_filiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

DROP TABLE IF EXISTS `fonctions`;
CREATE TABLE IF NOT EXISTS `fonctions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_fonction` varchar(50) NOT NULL,
  `code_fonction` varchar(50) NOT NULL,
  `etat_fonction` int NOT NULL,
  `description_fonction` text,
  `user_id` varchar(50) DEFAULT NULL,
  `hotel_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_fonction` (`code_fonction`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fonctions`
--

INSERT INTO `fonctions` (`id`, `libelle_fonction`, `code_fonction`, `etat_fonction`, `description_fonction`, `user_id`, `hotel_id`) VALUES
(1, 'Super Administrateur', '5wBEh2OfI00frxk8ITPf', 2, NULL, NULL, '5wBEh2OfI00frxk8ITPf'),
(2, 'Super Administrateur', 'Khec7SoqZWja1rUJksqbUQTsKqo', 2, NULL, NULL, 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(3, 'RECEPTION', 'NmUukWPBi6uFc5SGNzv855sE', 1, '', 'Khec7SoqZWja1rUJksqbUQTsKqo', 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(4, 'COMPTABLE', 'tuUV5fNExGRrnSVeN3fpLhcrvROR6Ka', 1, '', 'Khec7SoqZWja1rUJksqbUQTsKqo', 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(5, 'MANAGER', 'qkmDBGDnL63BhvauhZTNPI', 1, '', '5wBEh2OfI00frxk8ITPf', '5wBEh2OfI00frxk8ITPf'),
(6, 'COMPTA', 'y6Lfk6bC9dBDKI', 1, '', '5wBEh2OfI00frxk8ITPf', '5wBEh2OfI00frxk8ITPf'),
(7, 'Super Administrateur', '2X9hMvVynVX4CZmw3e47aPdJh8q2', 2, NULL, NULL, '2X9hMvVynVX4CZmw3e47aPdJh8q2'),
(8, 'Super Administrateur', 'OxcuaexoNJHM0u2EkiAHK', 2, NULL, NULL, 'OxcuaexoNJHM0u2EkiAHK'),
(9, 'Super Administrateur', 'Mkrg3s9tY13Dwx1hFdA', 2, NULL, NULL, 'Mkrg3s9tY13Dwx1hFdA'),
(10, 'Super Administrateur', 'wZtHJMFhsqDWhcRD3QZ', 2, NULL, NULL, 'wZtHJMFhsqDWhcRD3QZ'),
(11, 'Super Administrateur', 'qfJ8aqt', 2, NULL, NULL, 'qfJ8aqt'),
(12, 'Super Administrateur', 'N2umc2cjP86FqU6iHW', 2, NULL, NULL, 'N2umc2cjP86FqU6iHW'),
(13, 'Super Administrateur', 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 2, NULL, NULL, 'Kj01iHegEnAGDKLKkeAsFBalSzuc'),
(14, 'Super Administrateur', 'tIT3raq', 2, NULL, NULL, 'tIT3raq'),
(15, 'Super Administrateur', 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 2, NULL, NULL, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT'),
(16, 'Super Administrateur', 's5ooIYgE0lIEh35Y6GpvB', 2, NULL, NULL, 's5ooIYgE0lIEh35Y6GpvB'),
(17, 'Super Administrateur', 'fkUK15Q4temEUoYB5T9DUZ', 2, NULL, NULL, 'fkUK15Q4temEUoYB5T9DUZ');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `code_inscription` varchar(50) NOT NULL,
  `etudiant_code` varchar(50) NOT NULL,
  `classe_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `created_at_inscription` datetime DEFAULT NULL,
  `updated_at_inscription` datetime DEFAULT NULL,
  `montant_scolarite_inscription` decimal(10,2) DEFAULT '0.00',
  `statut_inscription` enum('valide','solde','annule') DEFAULT 'valide',
  PRIMARY KEY (`id_inscription`),
  UNIQUE KEY `uq_inscription` (`etudiant_code`,`annee_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `code_matiere` varchar(30) NOT NULL,
  `libelle_matiere` varchar(150) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `created_at_matiere` datetime NOT NULL,
  `updated_at_matiere` datetime DEFAULT NULL,
  `statut_matiere` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_matiere`),
  UNIQUE KEY `code_matiere` (`code_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `objet_message` varchar(255) NOT NULL,
  `description_message` text NOT NULL,
  `statut_message` enum('en_attente','envoye','vue','archive') DEFAULT 'en_attente',
  `created_at_message` datetime DEFAULT NULL,
  `update_at_message` datetime DEFAULT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int NOT NULL AUTO_INCREMENT,
  `code_niveau` varchar(50) NOT NULL,
  `libelle_niveau` varchar(100) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `filiere_code` varchar(50) NOT NULL,
  `created_at_niveau` datetime NOT NULL,
  `updated_at_niveau` datetime DEFAULT NULL,
  `statut_niveau` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_niveau`),
  UNIQUE KEY `uq_niveau_filiere` (`code_niveau`,`filiere_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `code_note` varchar(50) NOT NULL,
  `valeur_note` decimal(5,2) NOT NULL,
  `type_evaluation_code` varchar(50) NOT NULL,
  `observations` text,
  `inscription_code` varchar(50) NOT NULL,
  `matiere_code` varchar(50) NOT NULL,
  `semestre_code` varchar(50) NOT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `created_at_note` datetime NOT NULL,
  `updated_at_note` datetime DEFAULT NULL,
  `statut_note` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_note`),
  UNIQUE KEY `code_note` (`code_note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `code_paiement` varchar(50) NOT NULL,
  `montant_paiement` decimal(12,2) NOT NULL,
  `date_paiement` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut_paiement` enum('en_attente','confirme','annule','rembourse','echoue') NOT NULL DEFAULT 'confirme',
  `reference_paiement` varchar(100) DEFAULT NULL,
  `observations` text,
  `type_paiement` varchar(100) NOT NULL,
  `mode_paiement` varchar(50) NOT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `annee_code` varchar(50) DEFAULT NULL,
  `etablissement_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  UNIQUE KEY `code_paiement` (`code_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parents`
--

DROP TABLE IF EXISTS `parents`;
CREATE TABLE IF NOT EXISTS `parents` (
  `id_parent` int NOT NULL AUTO_INCREMENT,
  `code_parent` varchar(100) NOT NULL,
  `nom_pere` varchar(255) DEFAULT NULL,
  `telephone_pere` varchar(30) DEFAULT NULL,
  `profession_pere` varchar(100) DEFAULT NULL,
  `nom_mere` varchar(255) DEFAULT NULL,
  `telephone_mere` varchar(30) DEFAULT NULL,
  `profession_mere` varchar(100) DEFAULT NULL,
  `nom_tuteur` varchar(255) DEFAULT NULL,
  `telephone_tuteur` varchar(30) DEFAULT NULL,
  `created_at_parent` datetime NOT NULL,
  `updated_at_parent` datetime DEFAULT NULL,
  `etudiant_code` varchar(50) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id_parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code_role` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `groupe` varchar(50) NOT NULL,
  `etat_role` int NOT NULL DEFAULT '0',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_role` (`code_role`),
  KEY `groupe` (`groupe`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `code_role`, `module`, `groupe`, `etat_role`, `description`) VALUES
(1, 'ADMIN_H', 'ga1', 'ADMIN', 'GADMIN', 1, 'SUPPER ADMINISTRATEUR'),
(3, 'DASHBOARD_H ', 'ga3', 'ADMIN', 'GADMIN', 1, NULL),
(5, 'COMPTABLE_H ', 'gcom1', 'COMPTABLE', 'GCOMPT', 1, NULL),
(7, 'MANAGER_H ', 'gh1', 'HOTEL', 'GHOT', 1, NULL),
(8, 'SALAIRE_H ', 'gcom2', 'COMPTABLE', 'GCOMPT', 1, NULL),
(9, 'DEPENSE_H ', 'gh2', 'HOTEL', 'GHOT', 1, NULL),
(12, 'RECEPTION_H ', 'grecp1', 'RECEPTION', 'GRECP', 1, NULL),
(15, 'SUPER', 'sup1', 'SUPER', 'SUPER', 2, NULL),
(23, 'PARAMETRE', 'para1', 'PARAMETRE', 'PARA', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

DROP TABLE IF EXISTS `salles`;
CREATE TABLE IF NOT EXISTS `salles` (
  `id_salle` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_salle` varchar(20) NOT NULL,
  `libelle_salle` varchar(100) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `statut_salle` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_salle`),
  UNIQUE KEY `id_salle` (`id_salle`),
  UNIQUE KEY `code_salle` (`code_salle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `scolarites`
--

DROP TABLE IF EXISTS `scolarites`;
CREATE TABLE IF NOT EXISTS `scolarites` (
  `id_scolarite` int NOT NULL AUTO_INCREMENT,
  `code_scolarite` varchar(50) NOT NULL,
  `montant_scolarite` decimal(12,2) NOT NULL,
  `niveau_code` varchar(50) DEFAULT NULL,
  `filiere_code` varchar(50) DEFAULT NULL,
  `annee_code` varchar(50) DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `statut_scolarite` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  `created_at_scolarite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at_scolarite` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_scolarite`),
  UNIQUE KEY `code_scolarite` (`code_scolarite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE IF NOT EXISTS `semestres` (
  `id_semestre` int NOT NULL AUTO_INCREMENT,
  `code_semestre` varchar(50) NOT NULL,
  `libelle_semestre` varchar(50) NOT NULL,
  `etablissement_code` varchar(50) NOT NULL,
  `annee_code` varchar(50) NOT NULL,
  `date_debut_semestre` date DEFAULT NULL,
  `date_fin_semestre` date DEFAULT NULL,
  `created_at_semestre` datetime NOT NULL,
  `updated_at_semestre` datetime DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_semestre`),
  UNIQUE KEY `uq_semestre` (`code_semestre`,`annee_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_service` varchar(100) NOT NULL,
  `prix_service` int NOT NULL,
  `code_service` varchar(50) NOT NULL,
  `hotel_id` varchar(50) NOT NULL,
  `description_service` text,
  `etat_service` int NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `libelle_service`, `prix_service`, `code_service`, `hotel_id`, `description_service`, `etat_service`, `user_id`) VALUES
(1, 'DINER', 15000, 'NckiJHcKg8qEWhEO', 'Khec7SoqZWja1rUJksqbUQTsKqo', NULL, 1, 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(2, 'DEJEUNER', 8000, 'y1J36vhLWXiQQhUUKf3At5qGp9SMp4t', 'Khec7SoqZWja1rUJksqbUQTsKqo', NULL, 1, 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(3, 'LAVERIE', 5000, 'ljVm9Q3sxmRg9NSB9OQXHmQ6n9ghcQYw', 'Khec7SoqZWja1rUJksqbUQTsKqo', NULL, 1, 'Khec7SoqZWja1rUJksqbUQTsKqo'),
(4, 'SERV 01', 5000, 'bvmJ3Qbmlkh1g8d6Mnmfjg1F', '5wBEh2OfI00frxk8ITPf', '', 1, '5wBEh2OfI00frxk8ITPf'),
(5, 'SERVICE', 3000, 'rZlyshBhehHb6n3QJi0ir7H4gcs', '5wBEh2OfI00frxk8ITPf', '', 1, '5wBEh2OfI00frxk8ITPf'),
(6, 'NETOYAGE', 1200, '4rpT9St2ZOAU4bgeRaL0BWmKnqqxN', 'Khec7SoqZWja1rUJksqbUQTsKqo', 'Desc', 1, 'Khec7SoqZWja1rUJksqbUQTsKqo');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `code_user` varchar(50) NOT NULL,
  `nom_user` varchar(100) NOT NULL,
  `prenom_user` varchar(100) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `telephone_user` varchar(30) DEFAULT NULL,
  `photo_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_connexion` datetime DEFAULT NULL,
  `token_user` varchar(255) DEFAULT NULL,
  `etablissement_code` varchar(50) DEFAULT NULL,
  `created_at_user` datetime NOT NULL,
  `updated_at_user` datetime DEFAULT NULL,
  `statut_user` enum('actif','inactif') NOT NULL DEFAULT 'actif',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email_user` (`email_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `code_user`, `nom_user`, `prenom_user`, `email_user`, `password_user`, `telephone_user`, `photo_user`, `last_connexion`, `token_user`, `etablissement_code`, `created_at_user`, `updated_at_user`, `statut_user`) VALUES
(1, '5wBEh2OfI00frxk8ITPf', 'admin', 'admin', 'admin@gmail.com', '$2y$10$ik1kUCxvYJcPL2qhdMH.Iur04TxFgoDh8IhvA1vRgeT8Pfn5pl1AG', NULL, NULL, '2026-07-02 23:17:41', NULL, '123456789', '2026-07-01 19:50:44', NULL, 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `role_id` varchar(50) NOT NULL,
  `create_permission` int NOT NULL DEFAULT '0',
  `edit_permission` int NOT NULL DEFAULT '0',
  `show_permission` int NOT NULL DEFAULT '0',
  `delete_permission` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`role_id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `create_permission`, `edit_permission`, `show_permission`, `delete_permission`) VALUES
(1, '5wBEh2OfI00frxk8ITPf', 'sup1', 1, 1, 1, 1),
(2, '5wBEh2OfI00frxk8ITPf', 'para1', 1, 1, 1, 1),
(3, '5wBEh2OfI00frxk8ITPf', 'ga1', 1, 1, 1, 1),
(4, '5wBEh2OfI00frxk8ITPf', 'ga2', 1, 1, 1, 1),
(5, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'sup1', 1, 1, 1, 1),
(7, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'ga1', 1, 0, 0, 0),
(8, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'ga2', 1, 1, 1, 1),
(55, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'ga3', 1, 0, 0, 0),
(58, 'crCSUhJg0KSL', 'gcom2', 0, 0, 0, 0),
(60, 'crCSUhJg0KSL', 'ga3', 1, 0, 1, 0),
(61, 'crCSUhJg0KSL', 'ga1', 1, 1, 0, 0),
(62, 'crCSUhJg0KSL', 'gcom1', 0, 1, 0, 0),
(63, 'crCSUhJg0KSL', 'gh1', 0, 0, 0, 0),
(64, 'crCSUhJg0KSL', 'gh3', 0, 0, 0, 0),
(65, 'crCSUhJg0KSL', 'grecp1', 1, 0, 0, 0),
(66, 'crCSUhJg0KSL', 'para1', 0, 0, 1, 0),
(67, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'sup1', 1, 1, 1, 1),
(68, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'ga1', 1, 1, 1, 1),
(69, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'ga3', 1, 1, 1, 1),
(70, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'para1', 1, 1, 1, 1),
(71, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'gcom1', 1, 0, 0, 0),
(72, 'Kj01iHegEnAGDKLKkeAsFBalSzuc', 'gcom2', 1, 0, 0, 0),
(77, 'tIT3raq', 'sup1', 1, 1, 1, 1),
(78, 'tIT3raq', 'ga1', 1, 1, 1, 1),
(79, 'tIT3raq', 'ga3', 1, 1, 1, 1),
(80, 'tIT3raq', 'para1', 1, 1, 1, 1),
(81, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'sup1', 1, 1, 1, 1),
(82, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'ga1', 0, 0, 0, 0),
(83, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'ga3', 0, 0, 0, 0),
(84, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'para1', 0, 0, 0, 0),
(85, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'gh1', 0, 0, 0, 0),
(87, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'gh2', 0, 0, 0, 0),
(88, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'gcom2', 0, 0, 0, 0),
(89, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'gcom1', 0, 0, 0, 0),
(90, 'sBcEwwCX6eg61iXv5J3XUw5S00xi3xT', 'grecp1', 0, 0, 0, 0),
(110, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'gcom2', 1, 0, 0, 0),
(111, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'gcom1', 1, 0, 0, 0),
(112, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'gh2', 1, 0, 0, 0),
(113, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'gh1', 1, 0, 0, 0),
(115, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'para1', 1, 0, 0, 0),
(116, '6ucz4u2ERIoJ0Tlc1L', 'grecp1', 1, 0, 1, 0),
(117, 's5ooIYgE0lIEh35Y6GpvB', 'sup1', 1, 1, 1, 1),
(118, 's5ooIYgE0lIEh35Y6GpvB', 'ga1', 1, 1, 1, 1),
(119, 's5ooIYgE0lIEh35Y6GpvB', 'ga3', 1, 1, 1, 1),
(120, 's5ooIYgE0lIEh35Y6GpvB', 'para1', 1, 1, 1, 1),
(121, 'fkUK15Q4temEUoYB5T9DUZ', 'sup1', 1, 1, 1, 1),
(122, 'fkUK15Q4temEUoYB5T9DUZ', 'ga1', 1, 1, 1, 1),
(123, 'fkUK15Q4temEUoYB5T9DUZ', 'ga3', 1, 1, 1, 1),
(124, 'fkUK15Q4temEUoYB5T9DUZ', 'para1', 1, 1, 1, 1),
(125, 'Khec7SoqZWja1rUJksqbUQTsKqo', 'grecp1', 1, 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

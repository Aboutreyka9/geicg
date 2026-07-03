<?php

define('root', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
define('ASSETS', root . '/geicg/assets/');
define('LINK', root . '/geicg/');
define('HOME', root . '/geicg');
define('APP_NAME', 'G-EICG');
define('TWO_PIP', '/../../');
define('THREE_PIP', '/../../');

// const etat and status
define('ETAT_INACTIF', "0");
define('ETAT_ACTIF', "1");
define('ETAT_ATTENTE', "2");
define('BOUTIQUE_CODE', "BTQ_001");
define('COMPTE_CODE', "CMP_001");


class TABLES
{
    // Gestion académique
    public const ACCESSOIRES = 'accessoires';
    public const ACCESSOIRE_INSCRIPTION = 'accessoire_inscription';
    public const ANNEES = 'annees';
    public const CLASSES = 'classes';
    public const CYCLES = 'cycles';
    public const DOCUMENTS = 'documents';
    public const DOSSIER_ETUDIANT = 'dossier_etudiant';
    public const EMPLOIS_TEMPS = 'emplois_temps';
    public const ENSEIGNANTS = 'enseignants';
    public const ENSEIGNANT_MATIERE = 'enseignant_matiere';
    public const ETABLISSEMENTS = 'etablissements';
    public const ETUDIANTS = 'etudiants';
    public const EVENEMENTS = 'evenements';
    public const FILIERES = 'filieres';
    public const FONCTIONS = 'fonctions';
    public const INSCRIPTIONS = 'inscriptions';
    public const MATIERES = 'matieres';
    public const MESSAGES = 'messages';
    public const NIVEAUX = 'niveaux';
    public const NOTES = 'notes';
    public const PAIEMENTS = 'paiements';
    public const PARENTS = 'parents';
    public const ROLES = 'roles';
    public const SALLES = 'salles';
    public const SCOLARITES = 'scolarites';
    public const SEMESTRES = 'semestres';
    public const SERVICES = 'services';
    public const USERS = 'users';
    public const USER_ROLES = 'user_roles';
}

class Permissionsss
{
    const CREATE = 'create_permission';
    const EDIT = 'edit_permission';
    const VIEW = 'show_permission';
    const DELETE = 'delete_permission';
}

class Rolesss
{
    const ADMIN = 'ga';
    const DIRECTEUR = 'g1ad1';
    const ENSEIGNANT = 'g2pe2';
    const ECONOME = 'g1ad2';
    const EDUCATEUR = 'g2pe1';
    const ASSITANT = 'g1ad3';
    const SUPERVISOR = 'supervisor';
    const BIBLIOTHECAIRE = 'librarian';
    const STUDENT = 'student';
    const SECRETARY = 'secretary';
    const PARENT = 'parent';
}

class Groupesss
{
    const SUPER = 'ga';
    const ADMIN = 'g1';
    const PEDAGOGIE = 'g2';
}


// $sideBarData = [
//                 'test' =>[]
//             ];

const STATUT_CHAMBRE = ['Libre', 'Occupee', 'En nettoyage', 'Maintenance'];
const STATUT_RESERVATION = ['En cour', 'Confirmee', 'Annulee', 'Checkout'];
const PAIEMENT = ['Especes', 'Carte', 'Mobile money'];
const SEXEP = ['Entreprise', 'Mr', 'Mlle', 'Mme', 'Autre'];
const PIECES_DATA = ["CNI" => "CNI", "PASSEPORT" => "PASSEPORT", "CMU" => "CMU", "PERMIS" => "PERMIS", "CARTE CONSLAIRE" => "CARTE CONSLAIRE", "AUTRES" => "AUTRES"];

const EXTENSION = ["jpg", "png", "jpeg", "jfif", "webp", "svg", "gif", "bmp", "ico", "heic", "heif"];
const PERIODE = "periode";
const RESERVATION = "reservation";
const OLD_URL = "old_url";
const PROJECT_NAME = "geicg";
// CONST SEXE = ['G','F'];

const DAYS = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];


const MONTHS = [
    'Janvier',
    'Février',
    'Mars',
    'Avril',
    'Mai',
    'Juin',
    'Juillet',
    'Août',
    'Septembre',
    'Octobre',
    'Novembre',
    'Décembre'
];

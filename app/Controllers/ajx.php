<?php
session_name("APP675444554_SESSION");


session_start();
include __DIR__ . '/../../app/Core/security.php';

use App\Controllers\AuthController;
use App\Controllers\SettingController;
use App\Controllers\UserController;

require __DIR__ . '/../../vendor/autoload.php';



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}
// var_dump($_POST);

$action = $_POST['action'] ?? null;

switch ($action) {

    // Debut Actions authentification
    case 'btnLogin':
        $ajx = new AuthController();
        $ajx->authenticate();
        break;
    case 'btn_user_deconnect':
        $ajx = new AuthController();
        $ajx->deconnexion();
        break;

    // Debut Actions pour les utilisateurs
    case 'charger_data_utilisateurs':
        $ajx = new UserController();
        $ajx->GetListeUser();
        break;
    case 'change_statut_utilisateurs':
        $ajx = new UserController();
        $ajx->changeStatutUser();
        break;
    case 'btn_showmodal_role_permission_utilisateur':
        $ajx = new UserController();
        $ajx->modalAddPermission();
        break;
    case 'btn_load_data_role':
        $ajx = new UserController();
        $ajx->loadDataRole();
        break;
    case 'btn_add_permission':
        $ajx = new UserController();
        $ajx->ajouterRolesPermissions();
        break;
    case 'btn_showmodal_utilisateur_add':
        $ajx = new UserController();
        $ajx->modalAddUser();
        break;
    case 'btn_showmodal_utilisateur_update':
        $ajx = new UserController();
        $ajx->modalUpdatedUtilisateurr();
        break;
    case 'btn_add_user':
        $ajx = new UserController();
        $ajx->addUser();
        break;
    case 'btn_update_user':
        $ajx = new UserController();
        $ajx->updateUser();
        break;

    //end Actions pour les utilisateurs

    // Debut Actions pour les fonctions 
    case 'charger_data_fonctions':
        $ajx = new SettingController();
        $ajx->GetListeFonction();
        break;
    case 'change_statut_fonctions':
        $ajx = new SettingController();
        $ajx->changeStatutFonction();
        break;
    case 'btn_showmodal_fonction_add':
        $ajx = new SettingController();
        $ajx->modalAddFonction();
        break;
    case 'btn_showmodal_fonction_update':
        $ajx = new SettingController();
        $ajx->modalUpdatedFonction();
        break;
    case 'btn_add_fonction':
        $ajx = new SettingController();
        $ajx->addFonction();
        break;
    case 'btn_update_fonction':
        $ajx = new SettingController();
        $ajx->updateFonction();
        break;

    //end Actions pour les fonctions


    // Debut Actions pour services
    case 'charger_data_services':
        $ajx = new SettingController();
        $ajx->GetListeServices();
        break;
    case 'change_statut_services':
        $ajx = new SettingController();
        $ajx->changeStatutService();
        break;
    case 'btn_showmodal_service_add':
        $ajx = new SettingController();
        $ajx->modalAddService();
        break;
    case 'btn_showmodal_service_update':
        $ajx = new SettingController();
        $ajx->modalUpdatedService();
        break;
    case 'btn_add_service':
        $ajx = new SettingController();
        $ajx->addService();
        break;
    case 'btn_update_service':
        $ajx = new SettingController();
        $ajx->updateService();
        break;

    //end Actions pour les fonctions

    // Debut Actions pour les annees 
    case 'charger_data_annees':
        $ajx = new SettingController();
        $ajx->GetListeAnnee();
        break;
    case 'change_statut_annees':
        $ajx = new SettingController();
        $ajx->changeStatutAnnee();
        break;
    case 'btn_showmodal_annee_add':
        $ajx = new SettingController();
        $ajx->modalAddAnnee();
        break;
    case 'btn_showmodal_annee_update':
        $ajx = new SettingController();
        $ajx->modalUpdatedAnnee();
        break;
    case 'btn_add_annee':
        $ajx = new SettingController();
        $ajx->addAnnee();
        break;
    case 'btn_update_annee':
        $ajx = new SettingController();
        $ajx->updateAnnee();
        break;

    //end Actions pour les annees

    // Autres cas...
    default:
        echo json_encode(['status' => 'error', 'message' => 'Action inconnue']);
        break;
}

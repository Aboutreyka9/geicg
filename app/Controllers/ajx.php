
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
    case 'bcharger_data_utilisateurs':
        $ajx = new UserController();
        $ajx->bGetListeUser();
    break;
    case 'btn_showmodal_utilisateur_add':
        $ajx = new UserController();
        $ajx->modalAddUser();
    break;
     case 'btn_add_user':
        $ajx = new UserController();
        $ajx->addUser();
    break;

    //end Actions pour les utilisateurs

        // Debut Actions pour les fonctions
    case 'bcharger_data_fonctions':
        $ajx = new SettingController();
        $ajx->bGetListeFonction();
    break;
     case 'btn_add_fonction':
        $ajx = new SettingController();
        $ajx->addFonction();
    break;

    //end Actions pour les fonctions



    // Autres cas...
    default:
        echo json_encode(['status' => 'error', 'message' => 'Action inconnue']);
        break;
}


<?php
session_name("APP6846534_SESSION");


session_start();
include __DIR__ . '/../../app/Core/security.php';

use App\Controllers\BoutiqueController;
use App\Controllers\CategorieController;
use App\Controllers\ClientController;
use App\Controllers\Controller;
use App\Controllers\ControllerComptable;
use App\Controllers\ControllerHotel;
use App\Controllers\ControllerPrinter;
use App\Controllers\MarkController;
use App\Controllers\ProduitController;
use App\Controllers\UniteController;
use App\Controllers\FournisseurController;
use App\Controllers\UserController;

require __DIR__ . '/../../vendor/autoload.php';



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}
// var_dump($_POST);

$action = $_POST['action'] ?? null;
// var_dump($_POST);
// return;

switch ($action) {

    case 'aCharger_data_categories':
        $ajx = new CategorieController();
        $ajx->aGetListeCategorie();
        break;
    case 'btn_showmodal_categorie':
        $ajx = new CategorieController();
        $ajx->aModalAddCategorie();
        break;

    case 'btn_ajouter_categorie':
        $ajx = new CategorieController();

        $ajx->aAjouterCategorie();
        break;
        $ajx->amodalAddCategorie();
        break;

    case 'btn_ajouter_categorie':
        $ajx = new CategorieController();

        $ajx->aajouterCategorie();
        break;
    case 'modal_modifier_categorie':
        $ajx = new CategorieController();
        $ajx->aModalUpdateCategorie();
        break;
    case 'btn_modifier_categorie':
        $ajx = new CategorieController();
        $ajx->aUpdateCategorie();
        break;
    case 'btn_delete_categorie':
        $ajx = new CategorieController();
        $ajx->aDeleteCategorie();
        break;
    // ajouter Produit 
    case 'aCharger_data_produits':
        $ajx = new ProduitController();
        $ajx->aGetListeProduit();
        break;
    case 'btn_showmodal_produit':
        $ajx = new ProduitController();
        $ajx->aModalAddProduits();
        break;

    case 'btn_ajouter_produit':
        $ajx = new ProduitController();

        $ajx->aAjouterProduit();
        break;
    case 'modal_modifier_produit':
        $ajx = new ProduitController();
        $ajx->aModalUpdateProduit();
        break;
    case 'btn_modifier_produit':
        $ajx = new ProduitController();
        $ajx->aUpdateProduit();
        break;
    case 'btn_delete_produit':
        $ajx = new ProduitController();
        $ajx->aDeleteProduit();
        break;
        $ajx->amodalUpdateCategorie();
        break;
    case 'btn_modifier_categorie':
        $ajx = new CategorieController();
        $ajx->aupdateCategorie();
        break;
    case 'btn_delete_categorie':
        $ajx = new CategorieController();
        $ajx->adeleteCategorie();
        break;

    // ajouter mark 
    case 'aCharger_data_marks':
        $ajx = new MarkController();
        $ajx->aGetListeMark();
        break;
    case 'btn_showmodal_mark':
        $ajx = new MarkController();
        $ajx->aModalAddMark();
        break;

    case 'btn_ajouter_mark':
        $ajx = new MarkController();

        $ajx->aAjouterMark();
        break;
    case 'modal_modifier_mark':
        $ajx = new MarkController();
        $ajx->aModalUpdateMark();
        break;
    case 'btn_modifier_mark':
        $ajx = new MarkController();
        $ajx->aUpdateMark();
        break;
    case 'btn_delete_mark':
        $ajx = new MarkController();
        $ajx->aDeleteMark();
        break;

    // ajouter Unite 
    case 'aCharger_data_unites':
        $ajx = new UniteController();
        $ajx->aGetListeUnite();
        break;
    case 'btn_showmodal_unite':
        $ajx = new UniteController();
        $ajx->aModalAddUnite();
        break;

    case 'btn_ajouter_unite':
        $ajx = new UniteController();

        $ajx->aAjouterUnite();
        break;
    case 'modal_modifier_unite':
        $ajx = new UniteController();
        $ajx->aModalUpdateUnite();
        break;
    case 'btn_modifier_unite':
        $ajx = new UniteController();
        $ajx->aUpdateUnite();
        break;
    case 'btn_delete_unite':
        $ajx = new UniteController();
        $ajx->aDeleteUnite();
        break;

    // client
    case 'btn_recapt_liste_clients':
        $ajx = new ControllerHotel();
        $ajx->listeClientsRecapt();
        break;
    case 'btn_liste_clients':
        $ajx = new ControllerHotel();
        $ajx->listeClients();
        break;
    case 'btn_update_client':
        $ajx = new ControllerHotel();
        $ajx->updateClient();
        break;
    case 'bcharger_data_clients':
        // sleep(2);
        $ajx = new ClientController();
        $ajx->bGetListeClients();
        break;
    case 'btn_showmodal_client_add':
        $ajx = new ClientController();
        $ajx->bModalAddClient();
        break;
    case 'btn_add_client_data':
        $ajx = new ClientController();
        $ajx->bAddNewClient();
        break;
    case 'frm_modal_modifier_client':
        $ajx = new ClientController();
        $ajx->bModalUpdateClient();
        break;
    case 'btn_modifier_client_data':
        $ajx = new ClientController();
        $ajx->bUpdateClient();
        break;
    // end client
    // debut fournisseur

    case 'bcharger_data_fournisseurs':
        // sleep(2);
        $ajx = new FournisseurController();
        $ajx->bGetListeFournisseurs();
        break;
    case 'btn_showmodal_fournisseur_add':
        $ajx = new FournisseurController();
        $ajx->bModalAddFournisseur();
        break;
    case 'btn_add_fournisseur_data':
        $ajx = new FournisseurController();
        $ajx->bAddNewFournisseur();
        break;
    case 'frm_modal_modifier_fournisseur':
        $ajx = new FournisseurController();
        $ajx->bModalUpdateFournisseur();
        break;
    case 'btn_modifier_fournisseur_data':
        $ajx = new FournisseurController();
        $ajx->bUpdateFournisseur();
        break;

    // end fournisseur

    // debut boutique

    case 'get_schop_identity':
        // sleep(2);
        $ajx = new BoutiqueController();
        $ajx->bGetListeBoutique();
        break;
    case 'bcharger_boutiques':
        // sleep(2);
        $ajx = new BoutiqueController();
        $ajx->changeBoutique();
        break;
    case 'btn_showmodal_boutique_add':
        $ajx = new BoutiqueController();
        $ajx->bModalAddBoutique();
        break;
    case 'btn_add_boutique_data':
        $ajx = new BoutiqueController();
        $ajx->bAddNewBoutique();
        break;
    case 'frm_modal_modifier_boutique':
        $ajx = new BoutiqueController();
        $ajx->bModalUpdateBoutique();
        break;
    case 'btn_modifier_boutique_data':
        $ajx = new BoutiqueController();
        $ajx->bUpdateBoutique();
        break;

    // end fournisseur

    // ajouter chambre
    // case 'btn_showmodal_chambre':
    //     $ajx = new ControllerHotel();
    //     $ajx->modalAddChambre();
    //     break;
    // case 'btn_ajouter_chambre':
    //     $ajx = new ControllerHotel();
    //     $ajx->ajouterChambre();
    //     break;
    // case 'frm_update_chambre':
    //     $ajx = new ControllerHotel();
    //     $ajx->modalUpdateChambre();
    //     break;
    // case 'btn_modifier_chambre':
    //     $ajx = new ControllerHotel();
    //     $ajx->updateChambre();
    //     break;
    // case 'btn_delete_chambre':
    //     $ajx = new ControllerHotel();
    //     $ajx->deleteChammbre();
    //     break;



    //Debut depense

    // case 'btn_recapt_liste_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->listeDepenseRecapt();
    //     break;
    // case 'btn_liste_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->listeDepense();
    //     break;
    // case 'btn_showmodal_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->modalAddDepense();
    //     break;
    // case 'btn_ajouter_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->ajouterDepense();
    //     break;
    // case 'btn_confirm_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->confirmDepense();
    //     break;
    // case 'frm_update_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->modalUpdateDepense();
    //     break;
    // case 'btn_modifier_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->updateDepense();
    //     break;
    // case 'btn_delete_depense':
    //     $ajx = new ControllerComptable();
    //     $ajx->deleteDepense();
    //     break;
    // Fin depense

    // debut Salaire 

    // case 'btn_liste_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->listeSalaire();
    //     break;
    // case 'btn_showmodal_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->modalAddSalaire();
    //     break;
    // case 'btn_ajouter_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->ajouterSalaire();
    //     break;
    // case 'btn_confirm_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->confirmSalaire();
    //     break;
    // case 'frm_update_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->modalUpdateSalaire();
    //     break;
    // case 'btn_modifier_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->updateSalaire();
    //     break;
    // case 'btn_delete_salaire':
    //     $ajx = new ControllerComptable();
    //     $ajx->deleteSalaire();
    //     break;

    // Fin de Salaire 
    // Fin Actions pour les hotels


    // case 'pdf_facture':
    //     $fac = new ControllerPrinter();
    //     $fac->factureData();
    //     break;

    // case 'pdf_version_save':
    //     $pdfGen = new ControllerPrinter();
    //     $pdfGen->newVersionPdfSave();
    //     break;

    // Fin Actions pour les utilisateurs
        /**
         *  fIN Sexion data configuration
         */


        // SEXION CHART

    // case 'chart_bilan_dashboard':
    //     $pdfGen = new ControllerComptable();
    //     $pdfGen->bilanDashboard();
    //     break;

// END SEXION CHART


    /**
     * *******************
     * connexio et deconnexio de user 
     * *******************
     * */

    case 'update_hotel':
        $ajx = new UserController();
        $ajx->updateHotel();
        break;
    case 'btn_upload_logo':
        $ajx = new UserController();
        $ajx->updateLogo();
        break;


    case 'btnLogin':
        $ajx = new UserController();
        $ajx->loginUser();
        break;
    case 'btnRegister':
        $ajx = new UserController();
        $ajx->registerUser();
        break;
    case 'btn_update_user':
        $ajx = new UserController();
        $ajx->updateUser();
        break;
    case 'btn_reset_password':
        $ajx = new UserController();
        $ajx->resetPasswordUser();
        break;
    case 'btn_user_Deconnect':
        $ajx = new UserController();
        $ajx->deconnexion();
        break;

    case 'changer_password':
        $ajx = new UserController();
        $ajx->changePasswordUser();
        break;

    // Debut Actions pour les utilisateurs
    case 'btn_load_data_role':
        $ajx = new UserController();
        $ajx->loadDataRole();
        break;
    case 'btn_add_permission':
        $ajx = new UserController();
        $ajx->ajouterPermissionRole();
        break;
    case 'frm_modal_add_permission':
        $ajx = new UserController();
        $ajx->modalAddPermission();
        break;
    // ajouter utlisateur
    case 'bcharger_data_users':
        $ajx = new UserController();
        $ajx->bGetListeUser();
        break;
    case 'frm_modal_user':
        $ajx = new UserController();
        $ajx->modalAddUser();
        break;
    case 'btn_add_user':
        $ajx = new UserController();
        $ajx->addUser();
        break;

    case 'btn_disable_user':
        $ajx = new UserController();
        $ajx->disableUser();
        break;

    case 'btn_enable_user':
        $ajx = new UserController();
        $ajx->enableUser();
        break;
    case 'btn_send_mail_activation':
        $ajx = new UserController();
        $ajx->sendMailActivation();
        break;

    case 'btn_ouvrir_caisse';
        $ajx = new UserController();
        $ajx->openCaisse();
        break;
    case 'btn_fermer_caisse':
        $ajx = new UserController();
        $ajx->closeCaisse();
        break;

    //end Actions pour les utilisateurs



    // Autres cas...
    default:
        echo json_encode(['status' => 'error', 'message' => 'Action inconnue']);
        break;
}

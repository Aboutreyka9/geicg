
<?php
    session_name("APP15464655_SESSION");


session_start();

use App\Controllers\Controller;
use App\Controllers\ControllerComptable;
use App\Controllers\ControllerHotel;
use App\Controllers\ControllerPrinter;
use App\Controllers\UserController;

require __DIR__ . '/../../vendor/autoload.php';



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}
// var_dump($_POST);

$action = $_POST['action'] ?? null;

switch ($action) {
    /**
     * SEXION data configuration
     */
    
    // Debut Actions pour les utilisateurs
    case 'btn_load_data_role':
        $ajx = new Controller();
        $ajx->loadDataRole();
    break;
    case 'btn_add_permission':
        $ajx = new Controller();
        $ajx->ajouterPermissionRole();
    break;
    case 'frm_modal_add_permission':
        $ajx = new Controller();
        $ajx->modalAddPermission();
    break;
    // ajouter utlisateur
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

    // debut fonction 
    case 'frm_modal_fonction':
        $ajx = new UserController();
        $ajx->modalAddFonction();
    break;
    case 'btn_add_fonction':
        $ajx = new UserController();
        $ajx->addFonction();
    break;
    case 'frm_update_fonction':
        $ajx = new UserController();
        $ajx->modalModifierFonction();
    break;
    case 'btn_modifier_fonction':
        $ajx = new UserController();
        $ajx->modifierFonction();
    break;
    case 'btn_delete_fonction':
        $ajx = new UserController();
        $ajx->deleteFonction();
    break;

    // end fonction


    // Debut Actions pour les hotels
    case 'btn_search_chambre':
        $ajx = new ControllerHotel();
        $ajx->verification();
    break;
    case 'btn_search_telephone':
        // sleep(2);
        $ajx = new ControllerHotel();
        $ajx->verificationNumber();
    break;
     case 'btn_ajouter_client':
        // sleep(2);
        $ajx = new ControllerHotel();
        $ajx->addNewClient();
    break;
    case 'btn_showmodal_reservation':
        $ajx = new ControllerHotel();
        $ajx->modalShowReservation();
    break;
    case 'btn_ajouter_reservation':
        $ajx = new ControllerHotel();
        $ajx->ajouterReservation();
    break;
     case 'btn_recapt_liste_reservations':
        $ajx = new ControllerHotel();
        $ajx->listeReservationsRecapt();
    break;
    case 'btn_liste_reservations':
        $ajx = new ControllerHotel();
        $ajx->listeReservations();
    break;
     case 'btn_liste_reservations_active':
        $ajx = new ControllerHotel();
        $ajx->listeReservationsActive();
    break;
      case 'btn_liste_reservations_arrive':
        $ajx = new ControllerHotel();
        $ajx->listeReservationsArrive();
    break;
    case 'btn_delete_reservation':
        $ajx = new ControllerHotel();
        $ajx->deleteReservation();
    break;
    case 'btn_modal_confirme':
        $ajx = new ControllerHotel();
        $ajx->confirmReservation();
    break;
    case 'btn_add_facture':
        $ajx = new ControllerHotel();
        $ajx->factureReservtion();
    break;
    case 'frm_modal_service_reservation':
        $ajx = new ControllerHotel();
        $ajx->modalServiceReservation();
    break;
    case 'btn_modal_modifier_reservation':
        $ajx = new ControllerHotel();
        $ajx->modalUpdateReservation();
    break;
    case 'btn_ajouter_service_reservation':
        $ajx = new ControllerHotel();
        $ajx->attribuerServiceReservation();
    break;
    case 'frm_modal_modifier_service_reservation':
        $ajx = new ControllerHotel();
        $ajx->modalModifierServiceReservation();
    break;
    case 'btn_modifier_service_for_reservation':
        $ajx = new ControllerHotel();
        $ajx->modifierServiceForReservation();
    break;
    case 'btn_delete_service_reservation':
        $ajx = new ControllerHotel();
        $ajx->deleteServiceClient();
    break;
    case 'frm_modal_reglernote_service_reservation':
        $ajx = new ControllerHotel();
        $ajx->modalReglerNoteServiceReservation();
    break;
    case 'btn_facture_service_client':
        $ajx = new ControllerHotel();
        $ajx->reglerFactureServiceReservtion();
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

    // versement
    case 'frm_modal_detail_versement':
        $ajx = new ControllerHotel();
        $ajx->modalDetailsVersement();
    break;

    // confirm depot
    case 'btn_confirm_depot_user_comptable':
        $ajx = new ControllerComptable();
        $ajx->confirmDepotUserComptable();
    break;

    case 'btn_liste_depot_caisse_comptable':
        $ajx = new ControllerComptable();
        $ajx->listeDepotCaisseComptable();
    break;

    case 'btn_liste_bilant_caisse_comptable':
        $ajx = new ControllerComptable();
        $ajx->listeBilanCaisseComptable();
    break;

    // ajouter service chambre
    case 'btn_showmodal_service':
        $ajx = new ControllerHotel();
        $ajx->modalAddService();
    break;
    case 'btn_ajouter_service':
        $ajx = new ControllerHotel();
        $ajx->ajouterServices();
    break;
    case 'modal_modifier_service':
        $ajx = new ControllerHotel();
        $ajx->modalUpdateService();
    break;
    case 'btn_modifier_service':
        $ajx = new ControllerHotel();
        $ajx->updateService();
    break;
    case 'btn_delete_service':
        $ajx = new ControllerHotel();
        $ajx->deleteService();
    break;

    // ajouter categorie chambre
    case 'btn_showmodal_categorie':
        $ajx = new ControllerHotel();
        $ajx->modalAddCategorie();
    break;
    case 'btn_ajouter_categorie':
        $ajx = new ControllerHotel();
        $ajx->ajouterCategorieChambre();
    break;
    case 'modal_modifier_categorie':
        $ajx = new ControllerHotel();
        $ajx->modalUpdateCategorie();
    break;
    case 'btn_modifier_categorie':
        $ajx = new ControllerHotel();
        $ajx->updateCategoriChammbre();
    break;
    case 'btn_delete_categorie':
        $ajx = new ControllerHotel();
        $ajx->deleteCategorieChammbre();
    break;

    // ajouter chambre
    case 'btn_showmodal_chambre':
        $ajx = new ControllerHotel();
        $ajx->modalAddChambre();
    break;
    case 'btn_ajouter_chambre':
        $ajx = new ControllerHotel();
        $ajx->ajouterChambre();
    break;
    case 'frm_update_chambre':
        $ajx = new ControllerHotel();
        $ajx->modalUpdateChambre();
    break;
    case 'btn_modifier_chambre':
        $ajx = new ControllerHotel();
        $ajx->updateChambre();
    break;
    case 'btn_delete_chambre':
        $ajx = new ControllerHotel();
        $ajx->deleteChammbre();
    break;



    //Debut depense

     case 'btn_recapt_liste_depense':
        $ajx = new ControllerComptable();
        $ajx->listeDepenseRecapt();
    break;
    case 'btn_liste_depense':
        $ajx = new ControllerComptable();
        $ajx->listeDepense();
    break;
     case 'btn_showmodal_depense':
        $ajx = new ControllerComptable();
        $ajx->modalAddDepense();
    break;
    case 'btn_ajouter_depense':
        $ajx = new ControllerComptable();
        $ajx->ajouterDepense();
    break;
    case 'btn_confirm_depense':
        $ajx = new ControllerComptable();
        $ajx->confirmDepense();
    break;
    case 'frm_update_depense':
        $ajx = new ControllerComptable();
        $ajx->modalUpdateDepense();
    break;
    case 'btn_modifier_depense':
        $ajx = new ControllerComptable();
        $ajx->updateDepense();
    break;
    case 'btn_delete_depense':
        $ajx = new ControllerComptable();
        $ajx->deleteDepense();
    break;
    // Fin depense

    // debut Salaire 

    case 'btn_liste_salaire':
        $ajx = new ControllerComptable();
        $ajx->listeSalaire();
    break;
    case 'btn_showmodal_salaire':
        $ajx = new ControllerComptable();
        $ajx->modalAddSalaire();
    break;
    case 'btn_ajouter_salaire':
        $ajx = new ControllerComptable();
        $ajx->ajouterSalaire();
    break;
    case 'btn_confirm_salaire':
        $ajx = new ControllerComptable();
        $ajx->confirmSalaire();
    break;
    case 'frm_update_salaire':
        $ajx = new ControllerComptable();
        $ajx->modalUpdateSalaire();
    break;
    case 'btn_modifier_salaire':
        $ajx = new ControllerComptable();
        $ajx->updateSalaire();
    break;
    case 'btn_delete_salaire':
        $ajx = new ControllerComptable();
        $ajx->deleteSalaire();
    break;

    // Fin de Salaire 
    // Fin Actions pour les hotels


    case 'pdf_facture':
        $fac = new ControllerPrinter();
        $fac->factureData();
    break;
        
    case 'pdf_version_save':
        $pdfGen = new ControllerPrinter();
        $pdfGen->newVersionPdfSave();
    break;

    // Fin Actions pour les utilisateurs
    /**
     *  fIN Sexion data configuration
     */


// SEXION CHART

    case 'chart_bilan_dashboard':
        $pdfGen = new ControllerComptable();
        $pdfGen->bilanDashboard();
    break;

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
  
   

    // Autres cas...
    default:
        echo json_encode(['status' => 'error', 'message' => 'Action inconnue']);
    break;
}


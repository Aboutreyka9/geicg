<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Factory;
use App\Core\MainController;
use App\Helpers\HttpStatusCode;
use App\Helpers\Response;
use App\Helpers\Validator;
use App\Models\SettingModel;
use App\Services\SettingService;
use TABLES;

class SettingController extends MainController
{

// MODELS
  private SettingModel $settingModel;

//   SERVICES
  private SettingService $settingService;

    public function __construct()
    {
         parent::__construct();
        //  MODELS
        $this->settingModel = new SettingModel();
        
        // SERVICES
        $this->settingService = new SettingService();
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function fonction()
    {
        $this->view('admins/fonction', ['title' => "fonction"]);
    }


        /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function GetListeFonction()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $f = new SettingModel();

        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        // $search = $_POST['search'] ?? '';
        $search = $_POST['search']['value'] ?? '';




        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

             $likeParams = ['libelle_fonction' => $search, 'created_at_fonction' => $search, 'statut_fonction' => $search];
        }

        // 🔢 Total
        $total = $f->dataTbleCountTotalFonctionsRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $f->dataTbleCountTotalFonctionsRow($whereParams, $likeParams);
        // 📄 Données

        $fonctionList = $f->DataTableFetchFonctionsListe($likeParams, $start, $limit);
        $data = [];


        $data = $this->settingService->fonctionDataService($fonctionList);
        // Response::success('operation reussie',);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $fonctionList
        ]);
        // // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

    public function modalAddFonction()
    {

        $output = $this->settingService->fonctionAddModalService();
        Response::success('', ['data' => $output]);
    }

    public function modalUpdatedFonction()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        
        // $users = getAllusers();
        $fonction = $this->settingModel->getSingleFonctionByCode($codeFonction);
            

        $output = $this->settingService->fonctionUpdateModalService($fonction);
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie','success' => true]);
    }

    public function addFonction()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_fonction', $libelle_fonction, 'libelle fonction');
    
        if ($v->fails()) Response::error('Données invalides.', HttpStatusCode::UNPROCESSABLE_ENTITY, $v->errors());

        $result = $this->settingService->saveFonctionData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }
        
        Response::success($result['message'], []);


    }

      public function updateFonction()
    {
         $_POST = sanitizePostData($_POST);
        extract($_POST);
        $v = new Validator();

        $v->required('libelle_fonction', $libelle_fonction, 'Libellé fonction');
    
        if ($v->fails()) Response::error('Données invalides.', HttpStatusCode::UNPROCESSABLE_ENTITY, $v->errors());

        $result = $this->settingService->updateFonctionData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);

    }

      public function changeStatutFonction()
    {

       $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $statut_user = (isset($statut_utilisateur) && $statut_utilisateur != STATUT_INACTIF) ? STATUT_ACTIF : STATUT_INACTIF;
              

        if($this->settingModel->update(TABLES::FONCTIONS, 'code_fonction', $code_fonction, ['statut_fonction' => $statut_fonction])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);

    }

}
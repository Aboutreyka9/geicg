<?php

namespace App\Controllers;

use App\Models\Factory;
use App\Core\MainController;
use App\Helpers\HttpStatusCode;
use App\Helpers\Response;
use App\Helpers\Validator;
use App\Services\SettingService;

class SettingController extends MainController
{

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



    public function bGetListeFonction()
    {

        extract($_POST);
        $output = "";
        $user = new Factory();


        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        // $search = $_POST['search'] ?? '';
        $search = $_POST['search']['value'] ?? '';




        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

             $likeParams = ['nom_user' => $search, 'prenom_user' => $search, 'email_user' => $search, 'telephone_user' => $search, 'matricule_user' => $search, 'sexe_user' => $search, 'libelle_fonction' => $search, 'created_at_user' => $search];
        }

        // 🔢 Total
        $total = $user->dataTbleCountTotalUsersRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $user->dataTbleCountTotalUsersRow($whereParams, $likeParams);
        // 📄 Données

        $userList = $user->DataTableFetchUsersListe($likeParams, $start, $limit);

        $data = [];


        $data = UserService::userDataService($userList);
        // Response::success('operation reussie',);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $userList
        ]);
        // // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

        public function addFonction()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_fonction', $libelle_fonction, 'libelle fonction');
    
        if ($v->fails()) Response::error('Données invalides.', HttpStatusCode::UNPROCESSABLE_ENTITY, $v->errors());

        $result = $this->userService->saveUserData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        try {
            //code...
            $this->SendMail($email_user, "Création de compte", "activation", $result['data']);
            Response::success($result['message'], []);
        } catch (\Throwable $th) {
            //throw $th;
            Response::error("Desole verifier l'adresse du destinataire.", HttpStatusCode::NOT_FOUND);

        }

    }
}

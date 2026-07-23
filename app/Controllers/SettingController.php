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
        $this->view('admins/fonction', ['title' => "fonctions et services"]);
    }

    public function annee()
    {
        $this->view('admins/annee', ['title' => "Années et semestres"]);
    }


    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */


    // SEXION FONCTIO

    public function GetListeFonction()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $f = new SettingModel();

        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = (int) ($_POST['length'] ?? 10);
        $start  = (int) ($_POST['start'] ?? 0);
        $orderColumn = (int) ($_POST['order'][0]['column'] ?? 0);
        $orderDir    = strtolower($_POST['order'][0]['dir'] ?? 'asc');
        $search = trim($_POST['search']['value'] ?? '');
        // $search = $_POST['search'] ?? '';
        $columns = [
            0 => 'created_at_fonction',
            1 => 'statut_fonction',
            2 => 'libelle_fonction',
            3 => 'description_fonction',
            4 => 'created_at_fonction',
        ];

        $orderBy = $columns[$orderColumn] ?? 'libelle_fonction';
        $orderDir = $orderDir === 'desc' ? 'DESC' : 'ASC';



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

        $fonctionList = $f->DataTableFetchFonctionsListe($likeParams, $orderBy, $orderDir, $start, $limit);
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
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie', 'success' => true]);
    }

    public function addFonction()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_fonction', $libelle_fonction, 'libelle fonction');

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

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

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

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


        if ($this->settingModel->update(TABLES::FONCTIONS, 'code_fonction', $code_fonction, ['statut_fonction' => $statut_fonction])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }


    // SEXION SERVICES

    public function GetListeServices()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $f = new SettingModel();

        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = (int) ($_POST['length'] ?? 10);
        $start  = (int) ($_POST['start'] ?? 0);
        $orderColumn = (int) ($_POST['order'][0]['column'] ?? 0);
        $orderDir    = strtolower($_POST['order'][0]['dir'] ?? 'asc');
        $search = trim($_POST['search']['value'] ?? '');
        // $search = $_POST['search'] ?? '';
        $columns = [
            0 => 'created_at_service',
            1 => 'statut_service',
            2 => 'libelle_service',
            3 => 'description_service',
            4 => 'created_at_service',
        ];

        $orderBy = $columns[$orderColumn] ?? 'libelle_service';
        $orderDir = $orderDir === 'desc' ? 'DESC' : 'ASC';



        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

            $likeParams = ['libelle_service' => $search, 'created_at_service' => $search, 'statut_service' => $search];
        }

        // 🔢 Total
        $total = $f->dataTbleCountTotalServicesRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $f->dataTbleCountTotalServicesRow($whereParams, $likeParams);
        // 📄 Données

        $serviceList = $f->DataTableFetchServicesListe($likeParams, $orderBy, $orderDir, $start, $limit);
        $data = [];


        $data = $this->settingService->serviceDataService($serviceList);
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

    public function modalAddService()
    {

        $output = $this->settingService->serviceAddModalService();
        Response::success('', ['data' => $output]);
    }

    public function modalUpdatedService()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $users = getAllusers();
        $service = $this->settingModel->getSingleServiceByCode($codeService);


        $output = $this->settingService->serviceUpdateModalService($service);
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie', 'success' => true]);
    }

    public function addService()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_service', $libelle_service, 'libelle service');

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        $result = $this->settingService->saveServiceData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function updateService()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $v = new Validator();

        $v->required('libelle_service', $libelle_service, 'Libellé service');

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        $result = $this->settingService->updateServiceData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function changeStatutService()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $statut_user = (isset($statut_utilisateur) && $statut_utilisateur != STATUT_INACTIF) ? STATUT_ACTIF : STATUT_INACTIF;


        if ($this->settingModel->update(TABLES::SERVICES, 'code_service', $code_service, ['statut_service' => $statut_service])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }

    // SEXION ANNEE


    public function GetListeAnnee()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $f = new SettingModel();

        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = (int) ($_POST['length'] ?? 10);
        $start  = (int) ($_POST['start'] ?? 0);
        $orderColumn = (int) ($_POST['order'][0]['column'] ?? 0);
        $orderDir    = strtolower($_POST['order'][0]['dir'] ?? 'desc');
        $search = trim($_POST['search']['value'] ?? '');
        // $search = $_POST['search'] ?? '';
        $columns = [
            0 => 'libelle_annee',
            1 => 'statut_annee',
            2 => 'libelle_annee',
            3 => 'date_debut_annee',
            3 => 'date_fin_annee',
            4 => 'created_at_annee',
        ];

        $orderBy = $columns[$orderColumn] ?? 'libelle_annee';
        $orderDir = $orderDir === 'desc' ? 'DESC' : 'ASC';



        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

            $likeParams = ['libelle_annee' => $search, 'date_debut_annee' => $search, 'date_fin_annee' => $search, 'created_at_annee' => $search];
        }

        // 🔢 Total
        $total = $f->dataTbleCountTotalAnneesRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $f->dataTbleCountTotalAnneesRow($whereParams, $likeParams);
        // 📄 Données

        $anneeList = $f->DataTableFetchAnneesListe($likeParams, $orderBy, $orderDir, $start, $limit);
        $data = [];


        $data = $this->settingService->anneeDataService($anneeList);
        // Response::success('operation reussie',);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $anneeList
        ]);
        // // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

    public function modalAddAnnee()
    {

        $output = $this->settingService->anneeAddModalService();
        Response::success('', ['data' => $output]);
    }

    public function modalUpdatedAnnee()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $users = getAllusers();
        $annee = $this->settingModel->getSingleAnneeByCode($codeAnnee);


        $output = $this->settingService->anneeUpdateModalService($annee);
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie', 'success' => true]);
    }

    public function addAnnee()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_annee', $libelle_annee, 'libelle année')->valideYear('libelle_annee', $libelle_annee, 'libelle année')
            ->required('debut_annee', $debut_annee, 'Date debut')->inferieur('debut_annee', $debut_annee, 'Date debut', $fin_annee, 'Date fin')
            ->required('fin_annee', $fin_annee, 'Date fin')->superieur('fin_annee', $fin_annee, 'Date fin', $debut_annee, 'Date debut');

        // ->valideAcademieYear($libelle_annee, $debut_annee, $fin_annee);

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        if ($v->valideAcademieYear($libelle_annee, $debut_annee, $fin_annee) != 0) Response::error('Désolé, les dates selectionnées sont differentes de Libelle année', HttpStatusCode::UNAUTHORIZED);

        // var_dump($v->valideAcademieYear($libelle_annee, $debut_annee, $fin_annee));
        // return;

        $result = $this->settingService->saveAnneeData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function updateAnnee()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $v = new Validator();

        $v->required('libelle_annee', $libelle_annee, 'Libellé année');
        $v->required('libelle_annee', $libelle_annee, 'libelle année')->valideYear('libelle_annee', $libelle_annee, 'libelle année')
            ->required('debut_annee', $debut_annee, 'Date debut')->inferieur('debut_annee', $debut_annee, 'Date debut', $fin_annee, 'Date fin')
            ->required('fin_annee', $fin_annee, 'Date fin')->superieur('fin_annee', $fin_annee, 'Date fin', $debut_annee, 'Date debut');

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        if ($v->valideAcademieYear($libelle_annee, $debut_annee, $fin_annee) != 0) Response::error('Désolé, les dates selectionnées sont differentes de Libelle année', HttpStatusCode::UNAUTHORIZED);

        $result = $this->settingService->updateAnneeData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function changeStatutAnnee()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $statut_user = (isset($statut_utilisateur) && $statut_utilisateur != STATUT_INACTIF) ? STATUT_ACTIF : STATUT_INACTIF;


        if ($this->settingModel->update(TABLES::ANNEES, 'code_annee', $code_annee, ['statut_annee' => $statut_annee])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }

    // SEXION SEMESTRE


    public function GetListeSemestre()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $f = new SettingModel();

        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = (int) ($_POST['length'] ?? 10);
        $start  = (int) ($_POST['start'] ?? 0);
        $orderColumn = (int) ($_POST['order'][0]['column'] ?? 0);
        $orderDir    = strtolower($_POST['order'][0]['dir'] ?? 'desc');
        $search = trim($_POST['search']['value'] ?? '');
        // $search = $_POST['search'] ?? '';
        $columns = [
            0 => 'libelle_semestre',
            1 => 'statut_semestre',
            2 => 'libelle_semestre',
            3 => 'date_debut_semestre',
            3 => 'date_fin_semestre',
            4 => 'created_at_semestre',
        ];

        $orderBy = $columns[$orderColumn] ?? 'libelle_semestre';
        $orderDir = $orderDir === 'desc' ? 'DESC' : 'ASC';



        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

            $likeParams = ['libelle_semestre' => $search, 'date_debut_semestre' => $search, 'date_fin_semestre' => $search, 'created_at_semestre' => $search];
        }

        // 🔢 Total
        $total = $f->dataTbleCountTotalSemestresRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $f->dataTbleCountTotalSemestresRow($whereParams, $likeParams);
        // 📄 Données

        $semestreList = $f->DataTableFetchSemestresListe($likeParams, $orderBy, $orderDir, $start, $limit);
        $data = [];


        $data = $this->settingService->semestreDataService($semestreList);
        // Response::success('operation reussie',);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $semestreList
        ]);
        // // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

    public function modalAddSemestre()
    {
        $annees = $this->settingModel->getAllAnnees(Auth::user('etablissement_code'));
        if (empty($annees)) Response::error('Désolé, aucune année enregistrée!');

        $output = $this->settingService->semestreAddModalService($annees);
        Response::success('', ['data' => $output]);
    }

    public function modalUpdatedSemestre()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $users = getAllusers();
        $semestre = $this->settingModel->getSingleSemestreByCode($codesemestre);

        $annees = $this->settingModel->getAllAnnees(Auth::user('etablissement_code'));

        if (empty($semestre) || empty($annees)) Response::error('Désolé, une erreur est survenue lors du traitement!');

        $output = $this->settingService->semestreUpdateModalService($semestre, $annees);
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie', 'success' => true]);
    }

    public function addSemestre()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('libelle_semestre', $libelle_semestre, 'libelle année')
            ->required('debut_semestre', $debut_semestre, 'Date debut')->inferieur('debut_semestre', $debut_semestre, 'Date debut', $fin_semestre, 'Date fin')
            ->required('fin_semestre', $fin_semestre, 'Date fin')->superieur('fin_semestre', $fin_semestre, 'Date fin', $debut_semestre, 'Date debut');


        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        $result = $this->settingService->saveSemestreData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function updateSemestre()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $v = new Validator();

        $v->required('libelle_annee', $libelle_annee, 'Libellé année')
            ->required('libelle_semestre', $libelle_semestre, 'libelle semestre')
            ->required('debut_semestre', $debut_semestre, 'Date debut')->inferieur('debut_semestre', $debut_semestre, 'Date debut', $fin_semestre, 'Date fin')
            ->required('fin_semestre', $fin_semestre, 'Date fin')->superieur('fin_semestre', $fin_semestre, 'Date fin', $debut_semestre, 'Date debut');

        if ($v->fails()) Response::error($v->errors(), HttpStatusCode::UNAUTHORIZED);

        $result = $this->settingService->updateSemestreData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function changeStatutSemestre()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $statut_user = (isset($statut_utilisateur) && $statut_utilisateur != STATUT_INACTIF) ? STATUT_ACTIF : STATUT_INACTIF;


        if ($this->settingModel->update(TABLES::SEMESTRES, 'code_semestre', $code_semestre, ['statut_semestre' => $statut_semestre])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }
}

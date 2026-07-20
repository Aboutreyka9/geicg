<?php

namespace App\Controllers;

use Roles;
use App\Core\Gqr;
use App\Core\Auth;
use App\Models\UserModel;
use App\Models\Factory;
use App\Services\Service;
use App\Core\MainController;
use App\Helpers\HttpStatusCode;
use App\Helpers\Response;
use App\Helpers\Validator;
use App\Models\SettingModel;
use App\Services\SettingService;
use App\Services\UserService;
use Groupes;
use TABLES;

class UserController extends MainController
{

    // MODELS
    private SettingModel $settingModel;
    private UserModel $userModel;

    // SERVICES
    private SettingService $settingService;
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->settingModel = new SettingModel();
        $this->userModel = new UserModel();

        // SERVICES
        $this->settingService = new SettingService();
        $this->userService = new UserService();
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function acueil()
    {

        $result = "";

        return $this->view('welcome', ["result" => $result, "title", 'title' => "Mon espace"]);
    }

    public function recrutement()
    {
        $this->view('personnels/recrutement', ['title' => "Liste du personnel"]);
    }

    public function enseignants()
    {
        $this->view('personnels/enseignant', ['title' => "Liste des Enseignants"]);
    }

    public function administratif()
    {
        $this->view('personnels/liste', ['title' => "Liste des utilisateurs"]);
    }



    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function GetListeUser()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);


        $likeParams = [];
        $whereParams = ['etablissement_code' => Auth::user('etablissement_code')];


        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        // $search = $_POST['search'] ?? '';
        $search = $_POST['search']['value'] ?? '';

        $limit  = (int) ($_POST['length'] ?? 10);
        $start  = (int) ($_POST['start'] ?? 0);
        $orderColumn = (int) ($_POST['order'][0]['column'] ?? 0);
        $orderDir    = strtolower($_POST['order'][0]['dir'] ?? 'asc');
        $search = trim($_POST['search']['value'] ?? '');
        // $search = $_POST['search'] ?? '';
        $columns = [
            0 => 'nom_user',
            1 => 'statut_user',
            2 => 'nom_user',
            3 => 'prenom_user',
            4 => 'telephone_user',
            5 => 'libelle_fonction',
        ];

        $orderBy = $columns[$orderColumn] ?? 'libelle_fonction';
        $orderDir = $orderDir === 'desc' ? 'DESC' : 'ASC';




        // 🔎 Recherche
        if (!empty($search)) {
            // $likeParams = ['nom_user' => $search,'prenom_user' => $search,'email_user' => $search,'telephone_user' => $search,'matricule_user' => $search,'sexe_user' => $search];

            $likeParams = ['nom_user' => $search, 'prenom_user' => $search, 'email_user' => $search, 'telephone_user' => $search, 'matricule_user' => $search, 'sexe_user' => $search, 'libelle_fonction' => $search, 'created_at_user' => $search];
        }

        // 🔢 Total
        $total = $this->userModel->dataTbleCountTotalUsersRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $this->userModel->dataTbleCountTotalUsersRow($whereParams, $likeParams);
        // 📄 Données

        $userList = $this->userModel->DataTableFetchUsersListe($likeParams, $orderBy, $orderDir, $start, $limit);
        $data = [];


        $data = $this->userService->userDataService($userList);
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

    public function modalAddUser()
    {

        // $users = getAllusers();
        $fonctions = $this->settingModel->getAllFonctions(Auth::user('etablissement_code'));
        $services = $this->settingModel->getAllServices(Auth::user('etablissement_code'));
        // $services = getAllServices();
        if (empty($fonctions) || empty($services)) Response::error('Aucune fonction ou service trouvé');


        $output = $this->userService->userAddModalService($fonctions, $services);
        Response::success('', ['data' => $output]);
    }

    public function modalUpdatedUtilisateurr()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $users = getAllusers();
        $user = $this->userModel->getUserByCodeWithFoction($codeUtilisateur);
        $fonctions = $this->settingModel->getAllFonctions(Auth::user('etablissement_code'));
        $services = $this->settingModel->getAllServices(Auth::user('etablissement_code'));
        // $services = getAllServices();
        if (empty($fonctions) || empty($services)) Response::error('Aucune fonction ou service trouvé');


        $output = $this->userService->userUpdateModalService($user, $fonctions, $services);
        echo json_encode(['data' => $output, 'code' => 200, 'message' => 'operation reussie', 'success' => true]);
    }


    public function addUser()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('nom_user', $nom_user, 'Nom')
            ->required('prenom_user', $prenom_user, 'Prenoms')
            ->required('telephone_user', $telephone_user, 'Telephone')->phoneNumber('telephone_user', $telephone_user, 10, 'Telephone')
            ->required('email_user', $email_user, 'Email')->email('email_user', $email_user, 'Email')->required('sexe_user', $sexe_user, 'Civilité')->required('fonction_user', $fonction_user, 'Fonction')->required('service_user', $service_user, 'Service')->required('matricule_user', $matricule_user, 'Matricule');

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


    public function updateUser()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $v = new Validator();

        $v->required('nom_user', $nom_user, 'Nom')
            ->required('prenom_user', $prenom_user, 'Prenoms')
            ->required('telephone_user', $telephone_user, 'Telephone')->phoneNumber('telephone_user', $telephone_user, 10, 'Telephone')
            ->required('email_user', $email_user, 'Email')->email('email_user', $email_user, 'Email')->required('sexe_user', $sexe_user, 'Civilité')->required('fonction_user', $fonction_user, 'Fonction')->required('service_user', $service_user, 'Service')->required('matricule_user', $matricule_user, 'Matricule');

        if ($v->fails()) Response::error('Données invalides.', HttpStatusCode::UNPROCESSABLE_ENTITY, $v->errors());

        $result = $this->userService->updateUserData($_POST);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED);
        }

        Response::success($result['message'], []);
    }

    public function changeStatutUser()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        // $statut_user = (isset($statut_utilisateur) && $statut_utilisateur != STATUT_INACTIF) ? STATUT_ACTIF : STATUT_INACTIF;


        if ($this->userModel->update(TABLES::USERS, 'code_user', $code_utilisateur, ['statut_user' => $statut_utilisateur])) Response::success('Statut modifié avec succès', []);

        Response::error("Echec de l'opération", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }


    // SEXION ROLE PERMISSION


    public function loadDataRole()
    {

        $output = "";
        $_POST = sanitizePostData($_POST);
        extract($_POST);


        $roles = $this->userModel->getRolesByGroupe($code_role);

        $userPermissions = $this->userModel->getAllPermissionForUser($code_user);


        $userRolesPermissions = $this->userService->resolveTablePermission($userPermissions);
        // $output = $userRolesPermissions;

        if ($roles) {

            $output = $this->userService->DataTableRoles($userRolesPermissions, $roles);
        }

        // echo json_encode(['data' => $userRolesPermissions,'code' => 200]);
        echo json_encode(['data' => $output, 'code' => 200, 'success' => true]);
        return;
    }


    public function ajouterRolesPermissions()
    {

        // $_POST = sanitizePostData($_POST);
        extract($_POST);

        $rolesData = json_decode($_POST["roles"], true);

        if (empty($rolesData)) Response::error("Erreur de traitement de données!", HttpStatusCode::INTERNAL_SERVER_ERROR);

        if ($this->userService->saveRolesPermissionData($rolesData, $codeUtilisateur)) Response::success("Operation effectuée avec succès.", []);

        Response::error("Désolé une erreur est survenue lors du traitement.", HttpStatusCode::INTERNAL_SERVER_ERROR);
    }


    public function modalAddPermission()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);

        $html = "";

        $user = $this->userModel->getUser('code_user', $codeUtilisateur);
        if (empty($user)) Response::error("Désolé une erreur est survenue lors de l'operation,");

        $fullName = $user['nom_user'] . ' ' . $user['prenom_user'];
        $groupes = $this->userModel->groupes();
        if (empty($groupes)) Response::error("Désolé une erreur est survenue lors de l'operation,");

        $html = $this->userService->rolesDataGroupes($groupes, $codeUtilisateur);

        echo json_encode(['user' => $fullName, 'data' => $html, 'code' => 200, 'success' => true]);
        return;
    }
}
<?php

namespace App\Services;

use App\Core\Auth;
use App\Models\UserModel;
use TABLES;

class UserService
{

    public  UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION REQUETE 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public  function saveUserData($post)
    {
        extract($post);


        if (!empty($this->userModel->find(TABLES::USERS, 'telephone_user', $telephone_user))) {
            return ['success' => false, 'message' => 'Desolé! Ce numero de telephone existe déjà.'];
        }

        if (!empty($this->userModel->find(TABLES::USERS, 'email_user', $email_user))) {
            return ['success' => false, 'message' => 'Desolé! Cette adresse email existe déjà.'];
        }

        $passwrod = generetor(5);
        $code = $this->userModel->generatorCode(TABLES::USERS, 'code_user');
        $token = generetor(random_int(50, 70));

        $data_user = [
            'nom_user' => ucfirst($nom_user),
            'prenom_user' => ucfirst($prenom_user),
            'telephone_user' => $telephone_user,
            'code_user' => $code,
            'email_user' => strtolower($email_user),
            'matricule_user' => strtoupper($matricule_user),
            'sexe_user' => $sexe_user,
            'fonction_code' => $fonction_user,
            'etablissement_code' => Auth::user('etablissement_code'),
            'statut_user' => ETAT_INACTIF,
            'password_user' => password_hash($passwrod, PASSWORD_BCRYPT),
            'token_user' => $token,
            'created_at_user' => date('Y-m-d :H:i:s'),
        ];

        if (!$this->userModel->create(TABLES::USERS, $data_user)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }


        $etablissement =   $this->userModel->getInfoEtablissement(Auth::user('etablissement_code'));

        $data_mail = [
            "appName" => $_ENV["APP_NAME"],
            "libelle_structure" => $etablissement['libelle_etablissement'],
            "email" => $email_user,
            "password" => $passwrod,
            "nom" => strtoupper($nom_user . " " . $prenom_user),
            "lienActivation" => HOME . "/activation/{$token}"
        ];

        return [
            'success' => true,
            'message' => 'Utilisateur enregistré avec succès.',
            'data' => $data_mail
        ];
    }

    public  function updateUserData($post)
    {
        extract($post);


        $userphone = $this->userModel->find(TABLES::USERS, "telephone_user", $telephone_user);
        if (!empty($userphone) && $userphone['code_user'] != $code_user) {
            return ['success' => false, 'message' => 'Desolé! Ce numero de telephone existe déjà.'];
        }

        $userEmail = $this->userModel->find(TABLES::USERS, "email_user", $email_user);
        if (!empty($userEmail) && $userEmail['code_user'] != $code_user) {
            return ['success' => false, 'message' => 'Desolé! Cette adresse email existe déjà.'];
        }


        $data_user = [
            'nom_user' => ucfirst($nom_user),
            'prenom_user' => ucfirst($prenom_user),
            'telephone_user' => $telephone_user,
            'email_user' => strtolower($email_user),
            'matricule_user' => strtoupper($matricule_user),
            'sexe_user' => $sexe_user,
            'fonction_code' => $fonction_user,
            'created_at_user' => date('Y-m-d :H:i:s'),
        ];

        if (!$this->userModel->update(TABLES::USERS, 'code_user', $code_user, $data_user)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }

        return [
            'success' => true,
            'message' => 'Modification effectuée avec succès.',
        ];
    }

    public function resolveTablePermission($UserPermission)
    {

        $permissions = [];

        if (empty($UserPermission)) return [];

        foreach ($UserPermission as $key => $value) {

            $permissions[$value['role_id']] = [
                'create' => $value['create_permission'],
                'edit'   => $value['edit_permission'],
                'show'   => $value['show_permission'],
                'delete' => $value['delete_permission'],
            ];
        }

        return $permissions;
    }



    public function checkIfExistRole($user_permissions, $role)
    {
        return $user_permissions[$role['code_role']] ?? ['create' => 0, 'show' => 0, 'edit' => 0, 'delete' => 0];
    }

    function saveRolesPermissionData($rolesData, $codeUtilisateur)
    {

        $dataPermissions = [];
        foreach ($rolesData as $role) {

            if ($role["create"] || $role["show"] || $role["edit"] || $role["delete"]) {
                $dataPermissions = [
                    ':user_code' => $codeUtilisateur,
                    ':role_code' => $role["role"],
                    ':create_permission' => $role["create"],
                    ':show_permission' => $role["show"],
                    ':edit_permission' => $role["edit"],
                    ':delete_permission' => $role["delete"]
                ];
                $role = $this->userModel->createPermission($dataPermissions);
            } else {
                $role = $this->userModel->deletePermission($codeUtilisateur, $role["role"]);
            }
        }
        return ['success' => true, 'data' => '', 'code' => 200];
    }
    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION TEMPLATE 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */







    public  function userAddModalService(array $fonctions, array $services)
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmAddUser">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="hidden" value="btn_add_user" name="action">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="nom" class="form-label">Nom <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="nom" name="nom_user" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Prénoms <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="nom" name="prenom_user" required>
                    </div>

                </div>

                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="telephone" class="form-label">Téléphone <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control telephone" name="telephone_user" id="telephone" value="(+225)" required>
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="form-label">Adresse email <strong class="text-danger">*</strong></label>
                        <input type="email" class="form-control" id="email" name="email_user" required>
                    </div>

                    <div class="col-md-4">
                        <label for="matricule" class="form-label">Matricule <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" name="matricule_user" id="matricule" required>

                    </div>
                
                </div>

                <hr>
                <div class="row mb-3">

                    <div class="col-md-4">
                        <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                        <select name="sexe_user" class="form-control" id="sexe" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach (SEXEP as $sx) {
            $output .= '<option value="' . $sx . '">' . $sx . '</option>';
        }

        $output .= '
                                            </select>
                    </div>

                    <div class="col-md-4">
                        <label for="service" class="form-label">Service <strong class="text-danger">*</strong></label>
                        <select name="service_user" class="form-control" id="service" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach ($services as $se) {
            $output .= '<option value="' . $se['code_service'] . '">' . $se['libelle_service'] . '</option>';
        }

        $output .= '
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="fonction" class="form-label">Fonction <strong class="text-danger">*</strong></label>
                        <select name="fonction_user" class="form-control" id="fonction" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach ($fonctions as $fn) {
            $output .= '<option value="' . $fn['code_fonction'] . '">' . $fn['libelle_fonction'] . '</option>';
        }

        $output .= '
                        </select>
                    </div>

                </div>
               
                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Fermer</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }

    public  function userUpdateModalService(array $user, array $fonctions, array $services)
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmUpdateUser">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="hidden" value="btn_update_user" name="action">
                        <input type="hidden" value="' . $user['code_user'] . '" name="code_user">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="nom" class="form-label">Nom <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="nom" value="' . $user['nom_user'] . '" name="nom_user" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Prénoms <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="nom" value="' . $user['prenom_user'] . '" name="prenom_user" required>
                    </div>

                </div>

                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="telephone" class="form-label">Téléphone <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control telephone" name="telephone_user" id="telephone" value="' . $user['telephone_user'] . '" required>
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="form-label">Adresse email <strong class="text-danger">*</strong></label>
                        <input type="email" class="form-control" id="email" name="email_user" value="' . $user['email_user'] . '" required>
                    </div>

                    <div class="col-md-4">
                        <label for="matricule" class="form-label">Matricule <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" name="matricule_user" id="matricule" value="' . $user['matricule_user'] . '" required>

                    </div>
                
                </div>

                <hr>
                <div class="row mb-3">

                    <div class="col-md-4">
                        <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                        <select name="sexe_user" class="form-control" id="sexe" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach (SEXEP as $sx) {
            $output .= '<option ' . selected($user['sexe_user'] ?? null, $sx) . ' value="' . $sx . '">' . $sx . '</option>';
        }

        $output .= '
                                            </select>
                    </div>

                    <div class="col-md-4">
                        <label for="service" class="form-label">Service <strong class="text-danger">*</strong></label>
                        <select name="service_user" class="form-control" id="service" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach ($services as $se) {
            $output .= '<option ' . selected($user['service_code'] ?? null, $se['code_service']) . ' value="' . $se['code_service'] . '">' . strtoupper($se['libelle_service']) . '</option>';
        }

        $output .= '
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="fonction" class="form-label">Fonction <strong class="text-danger">*</strong></label>
                        <select name="fonction_user" class="form-control" id="fonction" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach ($fonctions as $fn) {
            $output .= '<option ' . selected($user['fonction_code'] ?? null, $fn['code_fonction']) . ' value="' . $fn['code_fonction'] . '">' . strtoupper($fn['libelle_fonction']) . '</option>';
        }

        $output .= '
                        </select>
                    </div>

                </div>
               
                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmitForm"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Fermer</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }

    public  function userDataService($users)
    {

        $i = 0;
        $data = [];

        foreach ($users as $user) {
            $i++;

            $etat = checkEtatData($user['statut_user']);

            $actions = '
            <button class="btn btn-light btn-link " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu">

        <a class="dropdown-item" href="" data-toggle="tooltip" title="" data-original-title="Voir les détails de la commande">
            <i class="fa fa-eye text-icon-info"></i> &nbsp; &nbsp; Voir details
        </a>
        <button class="dropdown-item " id="Modifier" onclick="modalUpdatedUtilisateurr(\'' . $user['code_user'] . '\')" 
            data-toggle="tooltip" title="" data-original-title="Modifier utilisateur">
        <i class="fa fa-edit text-icon-primary"></i> &nbsp; &nbsp; Modifier utilisateur </button>
         <button class="dropdown-item "  onclick="ModalAddrolePermissionUser(\'' . $user['code_user'] . '\')" 
            data-toggle="tooltip" title="" data-original-title="Rôles & permissions">
        <i class="fa fa-user-circle text-icon-warning"></i> &nbsp; &nbsp; Rôles & permissions </button>
        ';
            if ($user['statut_user'] == STATUT_ACTIF) {
                $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutUser(\'' . $user['code_user'] . '\',\'' . STATUT_INACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Désactiver compte ">
            <i class="fa fa-times text-icon-danger"></i> &nbsp; &nbsp; Désactiver compte </button>
        ';
            } else {
                $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutUser(\'' . $user['code_user'] . '\',\'' . STATUT_ACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Activer compte ">
            <i class="fa fa-check text-icon-success"></i> &nbsp; &nbsp; Activer compte </button>
        ';
            }
            $actions .= '
        <div role="separator" class="dropdown-divider"></div>

        <a class="dropdown-item " href="" target="_blank" data-toggle="tooltip" title="" data-original-title="Imprimer la facture de la commande">
            <i class="fas fa fa-print text-icon-dark"></i> &nbsp; &nbsp; Imprimer la commande commande </a>
    </div>
            ';

            $data[] = [
                $i,
                $etat,
                ucfirst($user['nom_user']),
                ucfirst($user['prenom_user']),
                $user['telephone_user'],
                ucfirst($user['libelle_fonction']),
                $actions
            ];
        }

        return $data;
    }



    public static function rolesDataGroupes($groupes, $code)
    {
        $output = '';
        foreach ($groupes as $data) {
            $output .= ' 
            <div class="role-container">
                    <div class="d-flex">
                    <div class="">
                    <input data-user="' . $code . '" data-groupe="' . $data['groupe'] . '" data-role="' . $data['code_role'] . '" type="checkbox" class="form-check-input me-2 toggle-role" id="r' . $data['code_role'] . '"> &nbsp;
                    <label for="r' . $data['code_role'] . '" class="role-title">' .  strtoupper($data['module']) . '</label>
                    </div>
                        <div class="">
                        </div>

                    </div>

                    <div class="permissions mt-3" id="permissions-r' . $data['code_role'] . '">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="45%">MODULES</th>
                                    <th>➕ AJOUTER</th>
                                    <th>👁️ VOIR</th>
                                    <th>✏️ MODIFIER</th>
                                    <th>❌ SUPPRIMER</th>
                                </tr>
                            </thead>
                            <tbody id="sexion-r' . $data['code_role'] . '">
                            </tbody>
                        </table>
                    </div>
                </div>
            ';
        }
        return $output;
    }

    public function DataTableRoles($userRolesPermissions, $roles)
    {
        $output = '';
        foreach ($roles as $data) {
            $equal = $this->checkIfExistRole($userRolesPermissions, $data);

            $c = $equal['create'] ? 'checked' : '';
            $s = $equal['show'] ? 'checked' : '';
            $e = $equal['edit'] ? 'checked' : '';
            $d = $equal['delete'] ? 'checked' : '';

            $output .= '
                <tr data-id="' . $data['code_role'] . '" >
                    <td> &nbsp; &nbsp;' . $data['libelle_role'] . '</td>
                    <td><input id="create' . $data['code_role'] . '" ' . $c . ' class="perm" data-type="create" type="checkbox"></td>
                    <td><input id="show' . $data['code_role'] . '" ' . $s . ' class="perm" data-type="show" type="checkbox"></td>
                    <td><input id="edit' . $data['code_role'] . '" ' . $e . ' class="perm" data-type="edit" type="checkbox"></td>
                    <td><input id="delete' . $data['code_role'] . '" ' . $d . ' class="perm" data-type="delete" type="checkbox"></td>
                </tr>
                ';
        }
        return $output;
    }


    /**
     * ------------------------------------------------------------------------
     * ****************************************************************
     * 
     * * FIN SEXION USER
     * ****************************************************************
     * --------------------------------------------------------------------------
     */
}

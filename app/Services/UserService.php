<?php

namespace App\Services;

use App\Core\Auth;
use App\Models\UserModel;
use TABLES;

class UserService
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION USER 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    function saveUserData($post)  {
        extract($post);
        $user = new UserModel();


        if (!empty($user->find(TABLES::USERS, 'telephone_user', $telephone_user))) 
            {
            return ['success' => false, 'message' => 'Desolé! Ce numero de telephone existe déjà.'];
            }

             if (!empty($user->find(TABLES::USERS, 'email_user', $email_user))) 
            {
            return ['success' => false, 'message' => 'Desolé! Cette adresse email existe déjà.'];
            }

            $passwrod = generetor(5);
            $code = $user->generatorCode(TABLES::USERS, 'code_user');
            $token = generetor(random_int(50, 70));

            $data_user = [
                'nom_user' => strtoupper($nom_user),
                'prenom_user' => strtoupper($prenom_user),
                'telephone_user' => $telephone_user,
                'code_user' => $code,
                'email_user' => $email_user,
                'matricule_user' => strtoupper($matricule_user),
                'sexe_user' => $sexe_user,
                'fonction_code' => $fonction_user,
                'etablissement_code' => Auth::user('etablissement_code'),
                'statut_user' => ETAT_INACTIF,
                'password_user' => password_hash($passwrod, PASSWORD_BCRYPT),
                'token_user' => $token,
                'created_at_user' => date('Y-m-d :H:i:s'),
            ];

            if (!$user->create(TABLES::USERS, $data_user))
            {
                return ['success' => false, 'message' => "Desolé! echec d'operation."];
            }


                $etablissement =   $user->getInfoEtablissement(Auth::user('etablissement_code'));

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


    public static function userAddModalService(array $fonctions,array $services)
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
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-50 modal_footer" id="btnSubmitForm"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                    </div>
                </div>


            </form> ';
        return $output;
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

    public static function userDataService($users)
    {

        $i = 0;
        $data = [];

        foreach ($users as $user) {
            $i++;

            $etat = $user['statut_user'] == STATUT_ACTIF ? '<span class="badge badge-success"> ✅ Actif</span>' : '<span class="badge badge-danger"> ❌ Desactivé</span>';

            $actions = '<div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
            Action
        </button>
        <div class="dropdown-menu">';

            if (!empty($user['token']) && $user['statut_user'] == STATUT_ACTIF) {
                $actions .= '
            <button class="dropdown-item btn_send_mail" data-user="' . $user['code_user'] . '">
                📧 Renvoyer mail
            </button>';
            }

            $actions .= '
        <a href="#" class="dropdown-item" data-user="' . $user['code_user'] . '">
            <i class="fa fa-print"></i> Imprimer
        </a>

        <a href="' . url('', ['code' => $user['code_user']]) . '" class="dropdown-item">
            👁‍🗨 Voir
        </a>';

            if (empty($user['token'])) {
                $actions .= $user['statut_user']
                    ? '<button class="dropdown-item btn_disable_user" data-user="' . $user['code_user'] . '">
                   ❌ Désactiver compte
               </button>'
                    : '<button class="dropdown-item btn_enable_user" data-user="' . $user['code_user'] . '">
                   ✅ Activer compte
               </button>';
            }

            $actions .= '</div></div>';

            $data[] = [
                $i,
                $user['email_user'],
                $user['nom_user'],
                $user['prenom_user'],
                $user['telephone_user'],
                $user['libelle_fonction'],
                $etat,
                $actions
            ];
        }

        return $data;
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

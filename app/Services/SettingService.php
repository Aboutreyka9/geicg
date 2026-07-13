<?php

namespace App\Services;

use App\Core\Auth;
use App\Models\Factory;
use App\Models\UserModel;
use TABLES;

class SettingService
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION SETTING 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public static function fonctionAddModalService()
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmAddFonction">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="hidden" value="btn_add_fonction" name="action">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" required>
                    </div>
                    <div class="col-md-12">
                        <label for="description_fonction" class="form-label">Description <strong class="text-danger">*</strong></label>
                        <textarea rows="3" name="description_fonction" id="description_fonction"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary w-50 " id="btnSubmitForm"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Close</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }

     function saveFonctionData(array $post)  {
        extract($post);
        $fac = new Factory();


        if (!empty($fac->where(TABLES::FONCTIONS, '', $telephone_user))) 
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



}

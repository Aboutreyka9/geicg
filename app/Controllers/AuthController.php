<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\User;

class AuthController extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */


    public function login()
    {
        return $this->viewGuest('auth/login', ["title" => "Connexion"]);
    }

    public function register()
    {
        return $this->viewGuest('auth/register', ["title" => "Création de compte"]);
    }

    public function resetPassword()
    {
        return $this->viewGuest('auth/reset', ["title" => "Création de compte"]);
    }

    public function changePassword()
    {
        return $this->viewGuest('auth/change', ["title" => "Création de compte"]);
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

       public  function loginUser()
    {

        $result = [];
        $result['code'] = 400;
        $etatCaise = null;
        $_POST = sanitizePostData($_POST);

        $login = $_POST['login'];
        $password = $_POST['password'];


        if (empty($login)) {
            $result['msg'] = "Veuillez renseigner votre login.";
        } elseif (empty($password)) {
            $result['msg'] = "Veuillez renseigner votre mot de passe.";
        } else {
            $fc = new User();
            // $fc->setKey('code_user');
            $user = [];

            $user = (filter_var($login, FILTER_VALIDATE_EMAIL)) ? $fc->getUserDataForLogin('email_user', $login) : $fc->getUserDataForLogin('telephone_user', $login);
            if (!empty($user) && password_verify($password, $user['password_user'])) {
                $groupes = [];
                $roles = [];

                // Vérifier si le compte est actif
                if (($user['etat_compte'] == ETAT_ACTIF)) {

                    // Récupérer les rôles de l'utilisateur
                    $rolesuser = $fc->getUserRoles($user['code_user']);

                    $Groupesuser = $fc->getUserGroups($user['code_user']);

                    // Mettre a jour lastime connection
                    $fc->update("users", "code_user", $user['code_user'], ['lastime' => date('Y-m-d H:i:s')]);

                    if (!empty($Groupesuser)) {
                        foreach ($Groupesuser as $groupe) {
                            $groupes[] = $groupe['groupe'];
                        }
                    }

                    if (!empty($rolesuser)) {
                        foreach ($rolesuser as $role) {

                            $roles[$role['code_role']] = [
                                'create' => (bool) $role['create_permission'],
                                'edit'   => (bool) $role['edit_permission'],
                                'show'   => (bool) $role['show_permission'],
                                'delete' => (bool) $role['delete_permission'],
                            ];
                        }
                    }


                    $caisse = $fc->getEtatCaisseUser($user['code_user'], $user['boutique_code']);
                    if (!empty($caisse) && $caisse['cloture'] == null) {
                        $etatCaise = $caisse['code_versement'];
                    }

                    Auth::login($user, $groupes, $roles, $etatCaise);
                    $result['activityYear'] = $fc->getYearActivityStart($user['boutique_code']);
                    $result['msg'] = "Connexion réussie !";
                    $result['code'] = 200;
                } else {
                    $result['msg'] = "Votre abonement a expiré. Veuillez contacter l'administrateur.";
                }
            } else {
                $result['msg'] = "Email/telephone  ou mot de passe incorrect !";
            }
        }

        echo json_encode($result);
        return;
    }

}

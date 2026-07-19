<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Helpers\HttpStatusCode;
use App\Helpers\Response;
use App\Helpers\Validator;
use App\Models\UserModel;
use App\Services\AuthService;

class AuthController extends MainController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

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

    public  function authenticate()
    {

        $result = [];
        $etatCaise = null;
        $_POST = sanitizePostData($_POST);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $v = new Validator();
        $v->required('email', $email, 'Email')->email('email', $email, 'Email')
            ->required('password', $password, 'Mot de passe');


        if ($v->fails()) Response::error('Données invalides.', HttpStatusCode::BAD_REQUEST, $v->errors());

        $result = $this->authService->login($email, $password);


        if (!$result['success']) {
            Response::error($result['message'], HttpStatusCode::UNAUTHORIZED, []);
        }

        Response::success($result['message'], []);
    }

    public function deconnexion()
    {
        if (Auth::check()) {
            Auth::disconect();
            Response::success("Déconnexion réussie", [], HttpStatusCode::OK);
        }
        Response::error("Vous n'êtes pas connecté", HttpStatusCode::UNAUTHORIZED, []);
    }
}

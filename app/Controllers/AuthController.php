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

    public function googleAuth()
    {


        $client = new Google_Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope('email');
        $client->addScope('profile');

        if (!isset($_GET['code'])) {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit();
        } else {

            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);


            $client->setAccessToken($token);
            $oauth2 = new Google_Service_Oauth2($client);
            $googleUser = $oauth2->userinfo->get();

            // Stocker les informations de l'utilisateur dans la session ou la base de données

            // $stmt = $db->prepare("SELECT * FROM users WHERE google_id = :google_id");
            $stmt = $db->prepare("SELECT * FROM users WHERE oauth_uid = :google_id AND oauth_provider = 'google'");
            $stmt->bindValue(':google_id', $googleUser->id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                // Si l'utilisateur n'existe pas, on le crée
                $stmt = $db->prepare("INSERT INTO users (oauth_uid, oauth_provider, name, email, picture) VALUES (:oauth_uid, :oauth_provider, :name, :email, :picture)");
                $stmt->bindValue(':oauth_uid', $googleUser->id);
                $stmt->bindValue(':oauth_provider', 'google');
                $stmt->bindValue(':name', $googleUser->name);
                $stmt->bindValue(':email', $googleUser->email);
                $stmt->bindValue(':picture', $googleUser->picture);
                $stmt->execute();
            }
            $_SESSION['user'] = [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'picture' => $googleUser->picture
            ];
            // Rediriger vers la page d'accueil
            header('Location: index.php');
            exit();
        }
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

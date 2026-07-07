<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Models\UserModel;

class AuthService
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login(string $email, string $password)
    {
        $user = $this->userModel->getUserDataForLogin('email_user',$email);
        $groupes = [];
        $roles = [];

        // if (empty($user)) {
        //     return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
        // }

        if (empty($user) || !password_verify($password, $user['password_user'])) {
            return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
        }

        // Mise à jour de la dernière connexion
        $this->userModel->updateLastConnexion($user['code_user']);
        
        // Récupérer les rôles de l'utilisateur
        $rolesuser = $this->userModel->getUserRoles($user['code_user']);
        $groupesuser = $this->userModel->getUserGroups($user['code_user']);
        
        if (!empty($groupesuser)) {
            foreach ($groupesuser as $groupe) {
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


        // Démarrer la session si pas encore démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Régénérer l'ID de session pour éviter la fixation de session
        session_regenerate_id(true);
        Auth::login($user,$groupes,$roles);

        return [
            'success' => true,
            'message' => 'Connexion réussie.'
        ];
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

      public static function check(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function getSessionUser(): array
    {
        if (!$this->isAuthenticated()) {
            return [];
        }
        return [
            'code_user'          => $_SESSION['user_code']          ?? '',
            'nom_user'           => $_SESSION['user_nom']           ?? '',
            'prenom_user'        => $_SESSION['user_prenom']        ?? '',
            'email_user'         => $_SESSION['user_email']         ?? '',
            'etablissement_code' => $_SESSION['etablissement_code'] ?? '',
        ];
    }

    /**
     * Middleware : vérifier l'authentification sur chaque route API.
     * Appeler en tête de chaque controller protégé.
     */
    public static function requireAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['logged_in'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'code'    => 401,
                'message' => 'Non authentifié. Veuillez vous connecter.',
            ]);
            exit;
        }
    }

    /**
     * Retourne l'établissement_code de la session courante.
     */
    public static function getEtablissementCode(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['etablissement_code'] ?? '';
    }

    /**
     * Retourne le user_code de la session courante.
     */
    public static function getUserCode(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_code'] ?? '';
    }
}

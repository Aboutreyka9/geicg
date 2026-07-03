<?php

namespace App\Middlewares;

use App\Core\Auth;
use Groupes;

class RouteMiddleWare
{


    public static function requireAuth(): void
    {
        if (!Auth::check()) {
            header('Location: ' . LINK . 'login');
            exit();
            // Auth::saveCurrentUrl();
            // self::redirect('login');
            // exit();
        }
    }

    public static function isLogged(): void
    {
        if (Auth::check()) {
            self::redirectBack();
        }
    }

    public static function requireComptable(): void
    {
        self::requireAuth();

        if (!Auth::hasGroupe(Groupes::COMPTABLE)) {
            //self::flash(" 🚫 Accès refusé : vous n'avez pas le groupe [".Groupes::COMPTABLE."]");
            self::redirectBack();
        }

        Auth::saveCurrentUrl();
    }

    public static function requireReception(): void
    {
        self::requireAuth();

        if (!Auth::hasGroupe(Groupes::RECEPTION)) {
            self::flash(" 🚫 Accès refusé : vous n'avez pas le groupe [" . Groupes::RECEPTION . "]");
            self::redirectBack();
        }

        Auth::saveCurrentUrl();
    }

    public static function requireGesHotel(): void
    {
        self::requireAuth();

        if (!Auth::hasGroupe(Groupes::HOTEL)) {
            self::flash(" 🚫 Accès refusé : vous n'avez pas le groupe [" . Groupes::HOTEL . "]");
            self::redirectBack();
        }

        Auth::saveCurrentUrl();
    }

    public static function requireSetting(): void
    {
        self::requireAuth();

        if (!Auth::hasGroupe(Groupes::PARAMETRE)) {
            self::flash(" 🚫 Accès refusé : vous n'avez pas le groupe [" . Groupes::PARAMETRE . "]");
            self::redirectBack();
        }

        Auth::saveCurrentUrl();
    }

    public static function requireAdmin(): void
    {
        self::requireAuth();

        if (!Auth::hasGroupe(Groupes::ADMIN)) {
            self::flash(" 🚫 Accès refusé : vous n'avez pas le groupe [" . Groupes::ADMIN . "]");
            self::redirectBack();
            // self::redirect('');
            // exit();
        }

        Auth::saveCurrentUrl();
    }

    public static function requireGroupe(int $groupeId): void
    {
        if (!Auth::hasGroupe($groupeId)) {
            http_response_code(403);
            die("🚫 Accès refusé : vous n'avez pas le groupe [$groupeId].");
        }
    }

    public static function requireRole(int $role): void
    {
        if (!Auth::hasGroupe($role)) {
            http_response_code(403);
            die("🚫 Accès refusé : vous n'avez pas le role [$role].");
        }
    }

    public static function requirePermission(int $roleId, string $permission): void
    {
        if (!Auth::can($roleId, $permission)) {
            http_response_code(403);
            die("🚫 Accès refusé : vous n'avez pas la permission [$permission].");
        }
    }

    public static function redirect(string $url = ''): void
    {
        if ($url === '') {
            $url = '/';
        }

        header('Location: ' . LINK . $url);
        exit();
    }
    public static function redirectTo(string $url): void
    {
        self::redirect($url);
    }

    public static function redirectBack()
    {
        $redirect = Auth::flashUrl('url') ?? '';
        self::redirect($redirect);
        // header('Location: ' . );
        // exit();
    }

    public static function flash(string $message, string $fallback = '/'): void
    {
        Auth::updateFlash('message', $message);

        // $redirect = Auth::user("old_url") ?? $fallback;


        // header("Location: $redirect");
        // exit;
    }
}

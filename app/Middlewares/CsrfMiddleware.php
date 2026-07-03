<?php

namespace App\Middlewares;

use App\Core\Auth;
use Groupes;


class CsrfMiddleware
{
    private static string $sessionKey = '_csrf_token';
    private static string $tokenTimeKey = 'csrf_token_time';

    /**
     * Génère ou retourne le token CSRF
     */
    public static function token(): string
    {
        if (empty($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = bin2hex(random_bytes(32));
            // valable pendant 30 minutes.
            $_SESSION[self::$tokenTimeKey] = time() + 1800;
        }

        return $_SESSION[self::$sessionKey];
    }

    /**
     * Vérifie le token CSRF
     */
    public static function verify(?string $token): void
    {

        $max = 1800; // 30 min

        // $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        if (
            empty($token) ||
            empty($_SESSION[self::$sessionKey]) || time() - $_SESSION[self::$tokenTimeKey] > $max ||
            !hash_equals($_SESSION[self::$sessionKey], $token)
        ) {
            self::reject();
        }
    }

    /**
     * Supprime le token (rotation possible)
     */
    public static function refresh(): void
    {
        unset($_SESSION[self::$sessionKey]);
        unset($_SESSION[self::$tokenTimeKey]);
        self::token();
    }

    /**
     * Bloque la requête
     */
    private static function reject(): void
    {
        http_response_code(403);
        echo json_encode([
            'status' => 'error',
            'message' => 'CSRF token invalide ou manquant'
        ]);
        exit;
    }
}

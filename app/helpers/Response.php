<?php

declare(strict_types=1);

namespace App\Helpers;

class Response
{
    public static function json(bool $success, int $code, string $message, array $data = [], array $errors = []): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);

        $payload = [
            'success' => $success,
            'code'    => $code,
            'message' => $message,
        ];

        if (!empty($data)) {
            $payload['data'] = $data;
        }
        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }

        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success(string $message, array $data = [], int $code = 200): void
    {
        self::json(true, $code, $message, $data);
    }

    public static function error(string $message, int $code = 400, array $errors = []): void
    {
        self::json(false, $code, $message, [], $errors);
    }

    public static function unauthorized(string $message = 'Non autorisé.'): void
    {
        self::json(false, 401, $message);
    }

    public static function notFound(string $message = 'Ressource introuvable.'): void
    {
        self::json(false, 404, $message);
    }

    public static function serverError(string $message = 'Erreur interne du serveur.'): void
    {
        self::json(false, 500, $message);
    }
}

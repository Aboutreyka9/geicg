<?php

declare(strict_types=1);

namespace App\Helpers;

class Validator
{
    private array $errors = [];

    public function required(string $field, mixed $value, string $label): self
    {
        if ($value === null || trim((string) $value) === '') {
            $this->errors[$field] = "Le champ « {$label} » est obligatoire.";
        }
        return $this;
    }

    public function email(string $field, mixed $value, string $label): self
    {
        if ($value !== null && trim((string) $value) !== '') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field] = "Le champ « {$label} » doit être un email valide.";
            }
        }
        return $this;
    }

    public function minLength(string $field, mixed $value, int $min, string $label): self
    {
        if ($value !== null && mb_strlen((string) $value) < $min) {
            $this->errors[$field] = "Le champ « {$label} » doit contenir au moins {$min} caractères.";
        }
        return $this;
    }

    public function maxLength(string $field, mixed $value, int $max, string $label): self
    {
        if ($value !== null && mb_strlen((string) $value) > $max) {
            $this->errors[$field] = "Le champ « {$label} » ne doit pas dépasser {$max} caractères.";
        }
        return $this;
    }

    public function in(string $field, mixed $value, array $allowed, string $label): self
    {
        if ($value !== null && !in_array($value, $allowed, true)) {
            $this->errors[$field] = "La valeur du champ « {$label} » est invalide.";
        }
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Nettoie et retourne une valeur string POST.
     */
    public static function clean(?string $value): string
    {
        return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Retourne POST[key] nettoyé ou null.
     */
    public static function post(string $key): ?string
    {
        $_POST = sanitizePostData($_POST);
        $value = $_POST[$key] ?? null;
        return $value !== null ? trim($value) : null;
    }
}

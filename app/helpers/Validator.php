<?php

declare(strict_types=1);

namespace App\Helpers;

class Validator
{
    private   string $errors;

    public function required(string $field, mixed $value, string $label): self
    {
        if ($value === null || trim((string) $value) === '') {
            $this->errors = "Le champ « {$label} » est obligatoire.";
        }
        return $this;
    }

    public function email(string $field, mixed $value, string $label): self
    {
        if ($value !== null && trim((string) $value) !== '') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors = "Le champ « {$label} » doit être un email valide.";
            }
        }
        return $this;
    }

    public function valideYear(string $field, mixed $value, string $label): self
    {
        if (!isValidSchoolYear($value)) {
            $this->errors = "Le champ « {$label} » est invalide.";
        }
        return $this;
    }

    public function valideAcademieYear(mixed $libelle_anne, mixed $date_debut, mixed $date_fin)
    {
        $date_debut = date('Y', strtotime($date_debut));
        $date_fin = date('Y', strtotime($date_fin));
        $year = "$date_debut-$date_fin";

        $result = compareAcademicYears($libelle_anne, $year);
        return $result;

        // if ($result != 0) {
        //     return false;
        // }
        // return true;
    }

    public function superieur(string $field, mixed $value, mixed $label, mixed $jocker, string $label2): self
    {
        if (strtotime($value) <= strtotime($jocker)) {
            $this->errors = "Le champ « {$label} » doit etre plus grand que {$label2}.";
        }
        return $this;
    }

    public function inferieur(string $field, mixed $value, mixed $label, mixed $jocker, string $label2): self
    {
        if (strtotime($value) >= strtotime($jocker)) {
            $this->errors = "Le champ « {$label} » doit etre plus petit que {$label2}.";
        }
        return $this;
    }

    public function digit(string $field, mixed $value, string $label): self
    {
        $value = removeSpace($value);
        if ($value !== null && !ctype_digit($value)) {
            $this->errors = "Le champ « {$label} » doit être valeur(s) numériques.";
        }
        return $this;
    }

    public function phoneNumber(string $field, mixed $value, int $length, string $label): self
    {

        if ($value !== null) {
            $old = $value;
            $value = removeSpace($value);
            $value = str_replace('(+225)', '', $value);
            if (!ctype_digit($value) || mb_strlen($value) !== $length) {

                $this->errors = "Le champ « {$label} » doit ètre egal à {$length} caractère(s) numeriques.";
            }
        }
        return $this;
    }

    public function length(string $field, mixed $value, int $length, string $label): self
    {
        if ($value !== null && mb_strlen((string) $value) != $length) {
            $this->errors = "Le champ « {$label} » doit contenir au moins {$length} caractères.";
        }
        return $this;
    }

    public function minLength(string $field, mixed $value, int $min, string $label): self
    {
        if ($value !== null && mb_strlen((string) $value) < $min) {
            $this->errors = "Le champ « {$label} » doit contenir au moins {$min} caractères.";
        }
        return $this;
    }

    public function maxLength(string $field, mixed $value, int $max, string $label): self
    {
        if ($value !== null && mb_strlen((string) $value) > $max) {
            $this->errors = "Le champ « {$label} » ne doit pas dépasser {$max} caractères.";
        }
        return $this;
    }

    public function in(string $field, mixed $value, array $allowed, string $label): self
    {
        if ($value !== null && !in_array($value, $allowed, true)) {
            $this->errors = "La valeur du champ « {$label} » est invalide.";
        }
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors()
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

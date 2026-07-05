<?php

namespace App\Core;

class Auth
{

    /**
     * Sauvegarde l’URL actuelle comme "ancienne"
     */
    public static function saveCurrentUrl(): void
    {
        $url = str_replace("/geicg/", "", $_SERVER["REQUEST_URI"]);
        self::create(OLD_URL, ['url' => $url]);
    }


    public static function getGroupes(): ?array
    {
        return self::check() ? self::user("groupes") : null;
    }
    public static function getRoles(): ?array
    {
        return self::check() ? self::user("roles") : null;
    }

    public static function getPermissionsRole($role): ?array
    {
        return !empty(self::getRoles()) ? self::getRoles()[$role] : null;
    }


    public static function create(string $key, array $data)
    {


        Session::set($key, $data);
    }
    public static function update(string $key,  $value)
    {

        Session::setAuth(self::getAuthKey(), $key, $value);
    }

    public static function updateFlash(string $key,  $value)
    {

        Session::setAuth(OLD_URL, $key, $value);
    }

    public static function login(array $user, array $groupes = [], array $roles = [], $etatCaisse = null): void
    {
        $authKey = "auth_conected";

        Session::set($authKey, [
            'id'    => $user['code_user'],
            'enseignant'    =>  $user['enseignant'],
            'nom'  => $user['nom_user'] . ' ' . $user['prenom_user'],
            'fonction' => $user['libelle_fonction'],
            "etablisement_code" => $user['etablissement_code'],
            "is_logged" => true,
            'groupes' => $groupes,
            'roles' => $roles
        ]);
    }

    public static function logout(): void
    {
        Session::remove(self::getAuthKey());
    }

    public static function clean(string $key): void
    {
        Session::remove($key);
    }

    public static function disconect(): void
    {
        Session::clear();
    }

    public static function user($key = null)
    {
        // return  null;
        return ($key !== null) ? Session::get(self::getAuthKey())[$key] : Session::get(self::getAuthKey());
    }

    public static function flashUrl($key = null)
    {
        return ($key !== null) ? Session::get(OLD_URL)[$key] : Session::get(OLD_URL);
    }

    public static function getData($key, $field = null)
    {

        return !empty($field) ?
            Session::get($key)[$field] :
            Session::get($key);
    }

    public static function getAuthKey()
    {
        return "auth_conected";
    }

    public static function check(): bool
    {
        if (!Session::has(self::getAuthKey())) return false;
        if (!self::user('is_logged')) return false;
        return true;
    }

    public static function id(): ?string
    {
        return self::check() ? self::user("id") : null;
    }

    public static function hasGroupe(string $groupeId): bool
    {
        return self::check() ? in_array($groupeId, self::getGroupes()) : false;
    }

    public static function hasRole(string $roleId): bool
    {

        return array_key_exists($roleId, self::getRoles());
    }

    public static function can(string $roleId, string $permission): bool
    {

        if (!isset(self::getRoles()[$roleId])) {
            return false;
        }

        return self::getRoles()[$roleId][$permission];
    }

    /**redirect fonction */
    public static function redirect(string $url): void
    {
        header("Location:" . HOME . $url);
        http_response_code(302);
        exit;
    }
}

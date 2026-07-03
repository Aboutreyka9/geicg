<?php
namespace App\Middlewares;



class AuthMiddleware 
{
   
    // public static function authenticated() {

    //     if (!self::check()) {
    //         self::urlRedirect("login");
    //         exit;
    //     }

    // }

    // public static function isLogged() {
    //     if (self::check()) {
    //         self::urlRedirect("/");
    //         exit;
    //     }

    // }

    // public static function can(string $role, string $permission): bool {
    //     // return self::hasPermission($role, $permission);
    // }

    // public static function hasRolesUser(string $role) {
    //     self::isLogged();
      
    //     if (!self::hasRole($role)) {
    //         http_response_code(403);
    //         echo "⛔ Accès refusé : permission requise.";
    //         exit;
    //     }
    // }

    // public static function hasGroupsUser(string $groupe){
    //     self::isLogged();
    //     if (!self::hasGroup($groupe)) {
    //         http_response_code(403);
    //         echo "⛔ Accès refusé : permission requise.";
    //         exit;
    //     }
    // }
  
}

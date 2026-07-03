<?php

namespace App\Core;

class Session
{

    public static function set( $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function setAuth( $key,$key2, $value): void
    {
        $_SESSION[$key][$key2] = $value;
    }
    public static function get( $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }


    public static function has( $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove( $key): void
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function clear(): void
    {
        session_destroy();
        $_SESSION = [];
    }

}

<?php

namespace App\Utils;

class CookiesManager
{
    public static function create(string $name, string $value, int $expiryDays = 365): bool
    {
        return setcookie($name, $value, time() + $expiryDays * 60 * 60 * 24, "/");
    }

    public static function delete(string $name): bool
    {
        return setcookie($name, "", time() - (60 * 60 * 24), "/");
    }

    public static function getCookie(string $name): string|false
    {
        return $_COOKIE[$name] ?? false;
    }

    public static function createRemember(): bool
    {
        return self::create("remember", "checked");
    }

    public static function deleteRemember(): bool
    {
        return self::delete("remember");
    }

    public static function existsRemember(): bool
    {
        return self::getCookie("remember");
    }
}

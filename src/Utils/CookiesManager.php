<?php

namespace App\Utils;

class CookiesManager
{
    public static function create(string $name, string $value, int $expiryDays = 365): bool
    {
        $expiryTime = time() + ($expiryDays * 86400);
        return setcookie($name, $value, $expiryTime, "/");
    }

    public static function delete(string $name): bool
    {
        $expiryTime = time() - 86400;
        return setcookie($name, "", $expiryTime, "/");
    }

    public static function get(string $name): string|false
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

    public static function hasRemember(): bool
    {
        return self::get("remember") !== false;
    }
}

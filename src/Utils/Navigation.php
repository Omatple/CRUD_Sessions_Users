<?php

namespace App\Utils;

class Navigation
{
    public static function redirectTo(string $namePage): void
    {
        header("Location: " . $namePage);
        exit();
    }

    public static function refresh(): void
    {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

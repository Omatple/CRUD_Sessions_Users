<?php

namespace App\Utils;

class Navigation
{
    public static function redirect(string $pageName): void
    {
        header("Location: " . $pageName);
        exit();
    }

    public static function reloadPage(): void
    {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

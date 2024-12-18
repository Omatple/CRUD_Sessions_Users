<?php

namespace App\Utils;

class SessionErrorDisplay
{
    public static function displayError(string $errorKey): void
    {
        if ($errorMessage = $_SESSION["error_{$errorKey}"] ?? null) {
            echo "<p class='text-sm text-red-700 font-italic font-semibold'>{$errorMessage}</p>";
            unset($_SESSION["error_{$errorKey}"]);
        }
    }
}

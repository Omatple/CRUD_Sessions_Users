<?php

namespace App\Utils;

class SessionErrorDisplay
{
    public static function showError(string $errorName): void
    {
        if ($errorMessage = $_SESSION["error_$errorName"] ?? false) {
            echo "<p class='text-sm text-red-700 font-italic font-semibold'>$errorMessage</p>";
            unset($_SESSION["error_$errorName"]);
        }
    }
}

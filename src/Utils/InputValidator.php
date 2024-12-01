<?php

namespace App\Utils;

class InputValidator
{
    public static function sanizite(string $input): string
    {
        return htmlspecialchars(trim($input));
    }

    public static function isValidLength(string $input, int $minChars, int $maxChars): bool
    {
        return strlen($input) >= $minChars && strlen($input) <= $maxChars;
    }
}

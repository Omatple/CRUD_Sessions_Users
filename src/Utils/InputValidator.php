<?php

namespace App\Utils;

class InputValidator
{
    public static function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function isValidLength(string $input, int $minChars, int $maxChars): bool
    {
        $inputLength = strlen($input);
        return $inputLength >= $minChars && $inputLength <= $maxChars;
    }
}

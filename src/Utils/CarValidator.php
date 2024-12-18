<?php

namespace App\Utils;

use App\Database\CarModel;

class CarValidator extends ImageProcessor
{
    public static function deleteOldImage(string $name): bool
    {
        return parent::removeImage($name, ImageConstants::CAR_IMAGE_PATH);
    }

    public static function isValidCarNameLength(string $name): bool
    {
        $minChars = 5;
        $maxChars = 100;
        if (!InputValidator::isValidLength($name, $minChars, $maxChars)) {
            $_SESSION['error_name'] = "The car name must be between {$minChars} and {$maxChars} characters.";
            return false;
        }
        return true;
    }

    public static function isValidBrandNameLength(string $brand): bool
    {
        $minChars = 3;
        $maxChars = 100;
        if (!InputValidator::isValidLength($brand, $minChars, $maxChars)) {
            $_SESSION['error_brand'] = "The brand name must be between {$minChars} and {$maxChars} characters.";
            return false;
        }
        return true;
    }

    public static function isValidHorsepower(int $horsepower): bool
    {
        $minPower = 50;
        $maxPower = 600;
        if ($horsepower < $minPower || $horsepower > $maxPower) {
            $_SESSION['error_horsepower'] = "Horsepower must be between {$minPower} and {$maxPower}.";
            return false;
        }
        return true;
    }

    public static function hasUploadedFile(int $errorCode): bool
    {
        return parent::isFileUploadedSuccessfully($errorCode);
    }

    public static function moveCarImage(string $from, string $to): bool
    {
        return parent::moveImage($from, $to);
    }

    public static function generateUniqueCarImageName(string $name): string
    {
        return parent::generateUniqueImageName($name, ImageConstants::CAR_IMAGE_PATH);
    }

    public static function isValidCarImage(array $imageData): bool
    {
        return parent::validateImage($imageData);
    }

    public static function isUniqueCar(string $name, string $brand, int $horsepower, ?int $id = null): bool
    {
        if (!CarModel::isCarUnique($name, $brand, $horsepower, $id)) {
            $_SESSION['error_uniqueCar'] = "A car with these characteristics already exists.";
            return false;
        }
        return true;
    }
}

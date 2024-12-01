<?php

namespace App\Utils;

use App\Database\UserEntity;
use Faker\Provider\UserAgent;

require __DIR__ . "/../../vendor/autoload.php";
class UserValidator
{
    public static function isValidLengthUsername(string $username): bool
    {
        $minChars = 4;
        $maxChars = 30;
        if (!InputValidator::isValidLength($username, $minChars, $maxChars)) {
            $_SESSION["error_username"] = "Username must be between $minChars and $maxChars.";
            return false;
        }
        return true;
    }

    public static function isValidLengthPassword(string $password): bool
    {
        $minChars = 8;
        $maxChars = 55;
        if (!InputValidator::isValidLength($password, $minChars, $maxChars)) {
            $_SESSION["error_password"] = "Password must be between $minChars and $maxChars.";
            return false;
        }
        return true;
    }

    public static function isValidEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error_email"] = "Must be a valid email.";
            return false;
        }
        return true;
    }

    public static function isValidConfirmPassword(string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            $_SESSION["error_password"] = "Confirm passsword don't match with password.";
            return false;
        }
        return true;
    }

    public static function isUniqueUsername(string $username, ?int $id = null): bool
    {
        return UserEntity::isFieldUnique("username", $username, $id);
    }

    public static function isUniqueEmail(string $email, ?int $id = null): bool
    {
        return UserEntity::isFieldUnique("email", $email, $id);
    }

    public static function  isUniqueFields(string $username, string $email): bool
    {
        if (!self::isUniqueUsername($username) || !self::isUniqueEmail($email)) {
            $_SESSION["error_uniqueFields"] = "Username or email already exist.";
            return false;
        }
        return true;
    }

    public static function isValidCredentials(string $email, string $password): bool
    {
        if (!($passwordUser = UserEntity::getPasswordByUniqueField("email", $email)) || !password_verify($password, $passwordUser)) {
            $_SESSION["error_credentials"] = "Email or password are incorrect.";
            return false;
        }
        return true;
    }

    public static function isRole(string $userRole, Role $role): bool
    {
        return $userRole === $role->toString();
    }
}

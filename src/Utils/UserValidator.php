<?php

namespace App\Utils;

use App\Database\UserModel;

class UserValidator extends ImageProcessor
{
    public static function isValidUsernameLength(string $username): bool
    {
        $minChars = 4;
        $maxChars = 30;
        if (!InputValidator::isValidLength($username, $minChars, $maxChars)) {
            $_SESSION['error_username'] = "Username must be between {$minChars} and {$maxChars} characters.";
            return false;
        }
        return true;
    }

    public static function isValidPasswordLength(string $password): bool
    {
        $minChars = 8;
        $maxChars = 55;
        if (!InputValidator::isValidLength($password, $minChars, $maxChars)) {
            $_SESSION['error_password'] = "Password must be between {$minChars} and {$maxChars} characters.";
            return false;
        }
        return true;
    }

    public static function isValidEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_email'] = "Please provide a valid email address.";
            return false;
        }
        return true;
    }

    public static function isPasswordConfirmationValid(string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            $_SESSION['error_password'] = "Password confirmation does not match the password.";
            return false;
        }
        return true;
    }

    public static function isUsernameUnique(string $username, ?int $id = null): bool
    {
        return UserModel::isFieldUnique('username', $username, $id);
    }

    public static function isEmailUnique(string $email, ?int $id = null): bool
    {
        return UserModel::isFieldUnique('email', $email, $id);
    }

    public static function areFieldsUnique(string $username, string $email, ?int $id = null): bool
    {
        if (!self::isUsernameUnique($username, $id) || !self::isEmailUnique($email, $id)) {
            $_SESSION['error_uniqueFields'] = "Username or email already exists.";
            return false;
        }
        return true;
    }

    public static function areCredentialsValid(string $email, string $password): bool
    {
        $passwordHash = UserModel::getPasswordByField('email', $email);
        if (!$passwordHash || !password_verify($password, $passwordHash)) {
            $_SESSION['error_credentials'] = "Invalid email or password.";
            return false;
        }
        return true;
    }

    public static function hasValidRole(string $userRole, Role $role): bool
    {
        return $userRole === $role->getName();
    }

    public static function isValidImage(array $imageData): bool
    {
        return parent::validateImage($imageData);
    }

    public static function generateUniqueUserImageName(string $name): string
    {
        return parent::generateUniqueImageName($name, ImageConstants::USER_IMAGE_PATH);
    }

    public static function hasUploadedFile(int $errorCode): bool
    {
        return parent::isFileUploadedSuccessfully($errorCode);
    }

    public static function moveUserImage(string $from, string $to): bool
    {
        return parent::moveImage($from, $to);
    }

    public static function deleteOldImage(string $name): bool
    {
        return parent::removeImage($name, ImageConstants::USER_IMAGE_PATH);
    }

    public static function isValidRole(string $role): bool
    {
        $validRoles = array_map(fn($role) => $role->getName(), Role::cases());
        if (!in_array($role, $validRoles)) {
            $_SESSION['error_role'] = "Please select a valid role.";
            return false;
        }
        return true;
    }
}

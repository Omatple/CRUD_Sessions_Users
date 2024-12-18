<?php

use App\Database\UserEntity;
use App\Database\UserModel;
use App\Utils\InputValidator;
use App\Utils\Navigation;
use App\Utils\SessionErrorDisplay;
use App\Utils\UserValidator;

session_start();

require __DIR__ . "/../vendor/autoload.php";
if (isset($_SESSION["user"])) Navigation::redirect("cars/index.php");
if (isset($_POST["username"])) {
    $username = InputValidator::sanitize($_POST["username"]);
    $email = InputValidator::sanitize($_POST["email"]);
    $password = InputValidator::sanitize($_POST["password"]);
    $passwordConfirm = InputValidator::sanitize($_POST["passwordConfirm"]);
    $hasErrors = false;
    if (!UserValidator::isValidUsernameLength($username)) $hasErrors = true;
    if (!UserValidator::isValidEmail($email)) $hasErrors = true;
    if (!$hasErrors && !UserValidator::areFieldsUnique($username, $email)) $hasErrors = true;
    if (!UserValidator::isValidPasswordLength($password) || !UserValidator::isPasswordConfirmationValid($password, $passwordConfirm)) $hasErrors = true;
    if ($hasErrors) Navigation::reloadPage();
    (new UserModel)
        ->setUsername($username)
        ->setEmail($email)
        ->setPassword($password)
        ->setImage()
        ->setRole()
        ->saveUser();
    $_SESSION["message"] = "User created successly.";
    Navigation::redirect("login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Ángel Martínez Otero">
    <title>Register</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create an Account</h2>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" id="username" name="username"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your username" required>
                <?= SessionErrorDisplay::displayError("username") ?>
                <?= SessionErrorDisplay::displayError("uniqueFields") ?>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your email" required>
                <?= SessionErrorDisplay::displayError("email") ?>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your password" required>
                <?= SessionErrorDisplay::displayError("password") ?>
            </div>
            <div class="mb-4">
                <label for="confirm-password" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                <input type="password" id="passwordConfirm" name="passwordConfirm"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Confirm your password" required>
            </div>
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Register</button>
        </form>
        <p class="text-center text-gray-600 mt-4">Already have an account? <a href="login.php"
                class="text-blue-500 font-semibold">Sign In</a></p>
    </div>
</body>

</html>
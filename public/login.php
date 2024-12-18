<?php

use App\Database\UserEntity;
use App\Database\UserModel;
use App\Utils\CookiesManager;
use App\Utils\InputValidator;
use App\Utils\Navigation;
use App\Utils\NotificationAlert;
use App\Utils\SessionErrorDisplay;
use App\Utils\UserValidator;

session_start();
require __DIR__ . "/../vendor/autoload.php";

if (isset($_SESSION["user"])) Navigation::redirect("cars/index.php");
if (!CookiesManager::hasRemember() && CookiesManager::get("email")) {
    CookiesManager::delete("email");
    CookiesManager::delete("password");
    Navigation::reloadPage();
}
if (isset($_POST["email"])) {
    $email = InputValidator::sanitize($_POST["email"]);
    $password = InputValidator::sanitize($_POST["password"]);
    (isset($_POST["remember"])) ? CookiesManager::createRemember() : CookiesManager::deleteRemember();
    $hasErrors = false;
    if (!UserValidator::isValidEmail($email)) $hasErrors = true;
    if (!UserValidator::isValidPasswordLength($password)) $hasErrors = true;
    if ($hasErrors || !UserValidator::areCredentialsValid($email, $password)) Navigation::reloadPage();
    if (isset($_POST["remember"])) {
        CookiesManager::create("email", $email);
        CookiesManager::create("password", $password);
    }
    $_SESSION["user"] = UserModel::getUserByField("email", $email);
    $_SESSION["message"] = "You access your account.";
    Navigation::redirect("cars/index.php");
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
    <title>Login</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign in to your Account</h2>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" novalidate>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your email" value="<?= CookiesManager::get("email") ?>" required>
                <?= SessionErrorDisplay::displayError("email") ?>
                <?= SessionErrorDisplay::displayError("credentials") ?>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your password" value="<?= CookiesManager::get("password") ?>" required>
                <?= SessionErrorDisplay::displayError("password") ?>
            </div>
            <div class="w-1/2 flex items-center mb-4">
                <input type="checkbox" name="remember" value="remember"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:outline-none"
                    <?= CookiesManager::get("remember") ?>>
                <label for="remember" class="ml-2 text-gray-600">Remember me</label>
            </div>
            <button type="submit"
                class="mb-4 w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Sign
                In</button>
            <a href="cars/index.php"
                class="block w-full text-center bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Enter
                as Guest</a>
        </form>
        <p class="text-center text-gray-600 mt-4">Don´t have an account? <a href="register.php"
                class="text-blue-500 font-semibold">Create an Account</a></p>
    </div>
</body>

<?= NotificationAlert::displayAlert() ?>

</html>
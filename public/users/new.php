<?php

use App\Database\UserModel;
use App\Utils\ImageConstants;
use App\Utils\InputValidator;
use App\Utils\Navigation;
use App\Utils\Role;
use App\Utils\SessionErrorDisplay;
use App\Utils\UserValidator;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (!isset($_SESSION['user']) || !UserValidator::hasValidRole($_SESSION['user']['role'], Role::Admin)) {
    Navigation::redirect("../cars/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = InputValidator::sanitize($_POST['username']);
    $email = InputValidator::sanitize($_POST['email']);
    $password = InputValidator::sanitize($_POST['password']);
    $confirmPassword = InputValidator::sanitize($_POST['passwordConfirm']);
    $role = InputValidator::sanitize($_POST['role']);
    $imageData = $_FILES['image'] ?? null;

    $hasErrors = false;

    if (!UserValidator::isValidUsernameLength($username)) $hasErrors = true;
    if (!UserValidator::isValidEmail($email)) $hasErrors = true;
    if (!UserValidator::areFieldsUnique($username, $email)) $hasErrors = true;
    if (!UserValidator::isValidRole($role)) $hasErrors = true;
    if (!UserValidator::isValidPasswordLength($password) || !UserValidator::isPasswordConfirmationValid($password, $confirmPassword)) $hasErrors = true;

    $image = ImageConstants::DEFAULT_FILENAME;

    if ($imageData && UserValidator::hasUploadedFile($imageData['error'])) {
        if (!UserValidator::isValidImage($imageData)) {
            $hasErrors = true;
        } else {
            $uniqueImagePath = UserValidator::generateUniqueUserImageName($imageData['name']);
            if (!UserValidator::moveUserImage($imageData['tmp_name'], $uniqueImagePath)) {
                $hasErrors = true;
            } else {
                $image = basename($uniqueImagePath);
            }
        }
    }

    if ($hasErrors) {
        Navigation::reloadPage();
    }

    (new UserModel)
        ->setUsername($username)
        ->setEmail($email)
        ->setPassword($password)
        ->setImage($image)
        ->setRole($role)
        ->saveUser();

    $_SESSION['message'] = "User created successfully.";
    Navigation::redirect("index.php");
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
    <title>New User</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <section class="bg-white dark:bg-gray-900">
        <div class="px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Edit profile</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="text" name="username" id="username" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="User username" required="">
                        <?= SessionErrorDisplay::displayError("username") ?>
                        <?= SessionErrorDisplay::displayError("uniqueFields") ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="User email" required="">
                        <?= SessionErrorDisplay::displayError("email") ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="User password" required="">
                        <?= SessionErrorDisplay::displayError("password") ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="passwordConfirm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                        <input type="password" name="passwordConfirm" id="passwordConfirm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="User confirm password" required="">
                    </div>
                    <div>
                        <div class="flex items-center space-x-6 mt-4">
                            <div class="shrink-0">
                                <img id='preview_img' class="h-16 w-16 object-cover rounded-full" src="<?= "img/" . ImageConstants::DEFAULT_FILENAME ?>"
                                    alt="Current user photo" />
                            </div>
                            <label class="block">
                                <span class="sr-only">Choose user photo</span>
                                <input type="file" accept="image/*" id="image" name="image" class="block w-full text-sm text-slate-500
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-full file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-violet-50 file:text-violet-700
                                                      hover:file:bg-violet-100
                                                    " oninput="handlerFilePreview(this);" />
                            </label>
                        </div>
                        <?= SessionErrorDisplay::displayError("image") ?>
                    </div>
                    <div>
                        <label for="role"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Select role</option>
                            <?php foreach (Role::cases() as $role): ?>
                                <option value="<?= $role->getName() ?>"><?= $role->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= SessionErrorDisplay::displayError("role") ?>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                        Add user
                    </button>
                    <button type="reset"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg focus:ring-4 focus:ring-yellow-200 dark:focus:ring-yellow-900 hover:bg-yellow-800 ml-4">
                        Reset
                    </button>
                    <a href="index.php"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-red-200 dark:focus:ring-red-900 hover:bg-red-800 ml-4">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </section>
</body>

<script>
    function handlerFilePreview(input) {
        file = input.files[0];
        if (file) {
            previewImg = document.getElementById("preview_img");
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>

</html>
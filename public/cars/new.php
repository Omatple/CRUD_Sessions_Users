<?php

use App\Database\CarModel;
use App\Utils\CarValidator;
use App\Utils\ImageConstants;
use App\Utils\InputValidator;
use App\Utils\Navigation;
use App\Utils\Role;
use App\Utils\SessionErrorDisplay;
use App\Utils\UserValidator;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (
    !isset($_SESSION['user']) ||
    !UserValidator::hasValidRole($_SESSION['user']['role'], Role::Admin)
) {
    Navigation::redirect("index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = InputValidator::sanitize($_POST['name']);
    $brand = InputValidator::sanitize($_POST['brand']);
    $horsepower = (int) InputValidator::sanitize($_POST['horsepower']);
    $imageData = $_FILES['image'] ?? null;
    $hasErrors = false;

    if (!CarValidator::isValidCarNameLength($name)) $hasErrors = true;
    if (!CarValidator::isValidBrandNameLength($brand)) $hasErrors = true;
    if (!CarValidator::isValidHorsepower($horsepower)) $hasErrors = true;
    if (!$hasErrors && !CarValidator::isUniqueCar($name, $brand, $horsepower)) $hasErrors = true;

    $image = ImageConstants::DEFAULT_FILENAME;

    if ($imageData && CarValidator::hasUploadedFile($imageData['error'])) {
        if (!CarValidator::isValidCarImage($imageData)) {
            $hasErrors = true;
        } else {
            $uniqueImageName = CarValidator::generateUniqueCarImageName($imageData['name']);
            if (!CarValidator::moveCarImage($imageData['tmp_name'], $uniqueImageName)) {
                $hasErrors = true;
            } else {
                $image = basename($uniqueImageName);
            }
        }
    }

    if ($hasErrors) {
        Navigation::reloadPage();
    }

    (new CarModel)
        ->setName($name)
        ->setBrand($brand)
        ->setHorsepower($horsepower)
        ->setImage($image)
        ->saveCar();

    $_SESSION['message'] = "Car created successfully.";
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
    <title>New Car</title>
    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <section class="bg-white dark:bg-gray-900">
        <div class="px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">New Car</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data" novalidate>
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Car name" required="">
                        <?= SessionErrorDisplay::displayError("name") ?>
                        <?= SessionErrorDisplay::displayError("uniqueCar") ?>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <input type="text" name="brand" id="brand" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Car brand" required="">
                        <?= SessionErrorDisplay::displayError("brand") ?>
                    </div>
                    <div>
                        <div class="flex items-center space-x-6 mt-4">
                            <div class="shrink-0">
                                <img id='preview_img' class="h-16 w-16 object-cover rounded-full" src="<?= "img/" . ImageConstants::DEFAULT_FILENAME ?>"
                                    alt="Current car photo" />
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
                        <label for="horsepower" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Horsepower</label>
                        <input type="number" name="horsepower" id="horsepower" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Car horsepower" required="">
                        <?= SessionErrorDisplay::displayError("horsepower") ?>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                        Add car
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
<?php

use App\Database\CarModel;
use App\Utils\CarValidator;
use App\Utils\Navigation;
use App\Utils\Role;
use App\Utils\UserValidator;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (
    !isset($_SESSION['user']) ||
    !UserValidator::hasValidRole($_SESSION['user']['role'], Role::Admin)
) {
    Navigation::redirect("index.php");
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id && ($car = CarModel::getCarByField('id', $id))) {
    CarModel::deleteCar($id);
    CarValidator::deleteOldImage($car['image']);
    $_SESSION['message'] = "Car deleted successfully.";
}

Navigation::redirect("index.php");

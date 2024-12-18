<?php

use App\Database\UserModel;
use App\Utils\Navigation;
use App\Utils\Role;
use App\Utils\UserValidator;

session_start();
require __DIR__ . "/../../vendor/autoload.php";

if (
    !isset($_SESSION['user']) ||
    !UserValidator::hasValidRole($_SESSION['user']['role'], Role::Admin)
) {
    Navigation::redirect("../cars/index.php");
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id && ($user = UserModel::getUserByField('id', $id))) {
    UserModel::deleteUser($id);
    UserValidator::deleteOldImage($user['image']);

    if ($_SESSION['user']['id'] === $id) {
        session_destroy();
        Navigation::redirect("../cars/index.php");
    }

    $_SESSION['message'] = "User deleted successfully.";
}

Navigation::redirect("index.php");

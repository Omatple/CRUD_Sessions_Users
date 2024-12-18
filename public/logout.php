<?php

use App\Utils\Navigation;

session_start();
session_destroy();
require __DIR__ . "/../vendor/autoload.php";

Navigation::redirect("cars/index.php");

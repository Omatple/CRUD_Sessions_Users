<?php

use App\Database\CarEntity;
use App\Database\UserEntity;

require __DIR__ . "/../vendor/autoload.php";
do {
    $amount = (int) readline("Write the amount you want create fake users (5-50), or '0' to exit: ");
    if ($amount === 0) exit("\nExiting for request of the user..." . PHP_EOL);
    if ($amount < 5 || $amount > 50) echo "\nERROR: Amount must be between 5 and 50 includes" . PHP_EOL;
} while ($amount < 5 || $amount > 50);

UserEntity::resetTableUsers();
CarEntity::resetTableCars();

CarEntity::generateFakesCars();
UserEntity::generateFakesUsers($amount);
exit("\n$amount fake users has been created." . PHP_EOL);

<?php

use App\Database\CarModel;
use App\Database\UserModel;

require __DIR__ . "/../vendor/autoload.php";

do {
    $amount = (int) readline("Enter the number of fake users to create (5-50), or '0' to exit: ");
    if ($amount === 0) {
        exit("\nExiting as per user request..." . PHP_EOL);
    }
    if ($amount < 5 || $amount > 50) {
        echo "\nERROR: The amount must be between 5 and 50 inclusive." . PHP_EOL;
    }
} while ($amount < 5 || $amount > 50);

UserModel::clearUsersTable();
CarModel::clearCarsTable();

CarModel::generateFakeCars();
UserModel::generateFakeUsers($amount);

exit("\n$amount fake users have been created successfully." . PHP_EOL);

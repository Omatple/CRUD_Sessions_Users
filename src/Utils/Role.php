<?php

namespace App\Utils;

enum Role: string
{
    case Admin = "Admin";
    case User = "User";

    public function toString(): string
    {
        return $this->value;
    }
}

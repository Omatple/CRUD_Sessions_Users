<?php

namespace App\Utils;

enum Role: string
{
    case Admin = "Admin";
    case User = "User";

    public function getName(): string
    {
        return $this->value;
    }
}

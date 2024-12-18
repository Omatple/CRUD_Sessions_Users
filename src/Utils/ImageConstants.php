<?php

namespace App\Utils;

class ImageConstants
{
    public const DEFAULT_FILENAME = "default.png";
    public const MAX_IMAGE_SIZE = 2 * 1024 * 1024;
    public const ALLOWED_MIME_TYPES = ["image/gif", "image/png", "image/jpeg", "image/bmp", "image/webp"];
    public const USER_IMAGE_PATH = "users";
    public const CAR_IMAGE_PATH = "cars";
}

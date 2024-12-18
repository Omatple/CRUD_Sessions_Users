<?php

namespace App\Utils;

class ImageProcessor
{
    protected static function isFileUploadedSuccessfully(int $errorCode): bool
    {
        return $errorCode === UPLOAD_ERR_OK;
    }

    private static function isImageWithinAllowedSize(int $size): bool
    {
        if ($size > ImageConstants::MAX_IMAGE_SIZE) {
            $_SESSION['error_image'] = "Image cannot be larger than 2MB.";
            return false;
        }
        return true;
    }

    private static function isValidMimeType(string $mimeType): bool
    {
        if (!in_array($mimeType, ImageConstants::ALLOWED_MIME_TYPES)) {
            $_SESSION['error_image'] = "Please upload a valid image.";
            return false;
        }
        return true;
    }

    private static function isImageUploadedViaHTTP(string $tmpName): bool
    {
        if (!is_uploaded_file($tmpName)) {
            $_SESSION['error_image'] = "Please upload the file via HTTP.";
            return false;
        }
        return true;
    }

    protected static function generateUniqueImageName(string $name, string $directory): string
    {
        return __DIR__ . "/../../public/{$directory}/img/" . uniqid() . "-" . $name;
    }

    protected static function moveImage(string $from, string $to): bool
    {
        if (!move_uploaded_file($from, $to)) {
            $_SESSION['error_image'] = "Cannot save image, please try again.";
            return false;
        }
        return true;
    }

    protected static function removeImage(string $name, string $directory): bool
    {
        $image = basename($name);
        $absolutePath = __DIR__ . "/../../public/$directory/img/" . $image;

        if ($image !== ImageConstants::DEFAULT_FILENAME && file_exists($absolutePath)) {
            unlink($absolutePath);
            return true;
        }
        return false;
    }

    protected static function validateImage(array $imageData): bool
    {
        $size = $imageData['size'];
        $mimeType = $imageData['type'];
        $tmpName = $imageData['tmp_name'];

        return self::isImageUploadedViaHTTP($tmpName) &&
            self::isImageWithinAllowedSize($size) &&
            self::isValidMimeType($mimeType);
    }
}

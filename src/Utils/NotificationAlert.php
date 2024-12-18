<?php

namespace App\Utils;

class NotificationAlert
{
    public static function displayAlert(): void
    {
        if ($message = $_SESSION['message'] ?? null) {
            echo <<<HTML
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "{$message}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            HTML;
            unset($_SESSION['message']);
        }
    }
}

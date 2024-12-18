<?php

namespace App\Database;

use App\Utils\ImageConstants;
use App\Utils\Role;
use \Faker\Factory;
use \Mmo\Faker\FakeimgProvider;

require __DIR__ . "/../../vendor/autoload.php";

class UserModel extends QueryExecutor
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private string $image;

    public function saveUser(): void
    {
        parent::executeQuery(
            "INSERT INTO users (username, email, password, role, image) VALUES (:username, :email, :password, :role, :image)",
            "Failed to create user '{$this->username}'",
            [
                ":username" => $this->username,
                ":email"    => $this->email,
                ":password" => $this->password,
                ":role"     => $this->role,
                ":image"    => $this->image,
            ]
        );
    }

    public static function fetchAllUsers(): array
    {
        return parent::executeQuery(
            "SELECT * FROM users",
            "Failed to retrieve all users"
        )->fetchAll();
    }

    public function updateUser(int $id, bool $updatePassword = false): void
    {
        $passwordQuery = $updatePassword ? ", password = :password" : "";
        $parameters = [
            ":id"       => $id,
            ":username" => $this->username,
            ":email"    => $this->email,
            ":role"     => $this->role,
            ":image"    => $this->image
        ];

        if ($updatePassword) {
            $parameters[":password"] = $this->password;
        }

        parent::executeQuery(
            "UPDATE users SET username = :username, email = :email, role = :role, image = :image$passwordQuery WHERE id = :id",
            "Failed to update user with ID '$id'",
            $parameters
        );
    }

    public static function getUserByField(string $field, string $value): array|false
    {
        return parent::executeQuery(
            "SELECT * FROM users WHERE $field = :value",
            "Failed to retrieve user by field '$field'",
            [":value" => $value]
        )->fetch();
    }

    public static function generateFakeUsers(int $amount): void
    {
        $faker = Factory::create("es_ES");
        $faker->addProvider(new FakeimgProvider($faker));
        $randomColor = fn(): int => random_int(0, 255);

        for ($i = 0; $i < $amount; $i++) {
            $username = $faker->unique()->userName();
            $email = $username . "@" . $faker->freeEmailDomain();
            $password = $username . "2024.";
            $role = $faker->randomElement(Role::cases())->getName();
            $image = $faker->fakeImg(
                dir: __DIR__ . "/../../public/users/img/",
                width: 640,
                height: 640,
                fullPath: false,
                text: strtoupper(substr($username, 0, 3)),
                backgroundColor: [$randomColor(), $randomColor(), $randomColor()]
            );

            (new UserModel)
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setRole($role)
                ->setImage($image)
                ->saveUser();
        }
    }

    public static function resetUserImageToDefault(int $id): void
    {
        parent::executeQuery(
            "UPDATE users SET image = :image WHERE id = :id",
            "Failed to reset image for user with ID '$id'",
            [
                ":id"    => $id,
                ":image" => "img/" . ImageConstants::DEFAULT_FILENAME,
            ]
        );
    }

    public static function clearUsersTable(): void
    {
        parent::executeQuery("DELETE FROM users", "Failed to clear users table");
        parent::executeQuery("ALTER TABLE users AUTO_INCREMENT = 1", "Failed to reset auto-increment on users table");
    }

    public static function deleteUser(int $id): void
    {
        parent::executeQuery(
            "DELETE FROM users WHERE id = :id",
            "Failed to delete user with ID '$id'",
            [":id" => $id]
        );
    }

    public static function isFieldUnique(string $field, string $value, ?int $id = null): bool
    {
        $idCondition = is_null($id) ? "" : " AND id <> :id";
        $parameters = is_null($id) ? [":value" => $value] : [":value" => $value, ":id" => $id];

        return !parent::executeQuery(
            "SELECT count(*) FROM users WHERE $field = :value$idCondition",
            "Failed to verify uniqueness of field '$field'",
            $parameters
        )->fetchColumn();
    }

    public static function getPasswordByField(string $field, string $value): string|false
    {
        return parent::executeQuery(
            "SELECT password FROM users WHERE $field = :value",
            "Failed to retrieve password for field '$field'",
            [":value" => $value]
        )->fetchColumn();
    }

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(?string $role = null): self
    {
        $this->role = is_null($role) ? Role::User->getName() : $role;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(?string $image = null): self
    {
        $this->image = "img/" . ($image ?? ImageConstants::DEFAULT_FILENAME);
        return $this;
    }
}

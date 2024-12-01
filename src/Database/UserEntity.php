<?php

namespace App\Database;

use App\Utils\ImageConstants;
use App\Utils\Role;
use \Faker\Factory;
use \Mmo\Faker\FakeimgProvider;

require __DIR__ . "/../../vendor/autoload.php";
class UserEntity extends QueryExecutor
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private string $image;

    public function create(): void
    {
        parent::executeQuery(
            "INSERT INTO users (username, email, password, role, image) VALUES (:u, :e, :p, :r, :i)",
            "Failed to create user '{$this->username}'",
            [
                ":u" => $this->username,
                ":e" => $this->email,
                ":p" => $this->password,
                ":r" => $this->role,
                ":i" => $this->image,
            ]
        );
    }

    public static function read(): array
    {
        return parent::executeQuery(
            "SELECT * FROM users",
            "Failed retraving all users"
        )->fetchAll();
    }

    public static function getUserByUniqueField(string $uniqueField, string $value): array|false
    {
        return parent::executeQuery(
            "SELECT * FROM users WHERE $uniqueField = :v",
            "Failed retraiving user with $uniqueField",
            [
                ":v" => $value
            ]
        )->fetch();
    }

    public static function generateFakesUsers(int $amount): void
    {
        $faker = Factory::create("es_ES");
        $faker->addProvider(new FakeimgProvider($faker));
        $randomColor = fn(): int => random_int(0, 255);
        for ($i = 0; $i < $amount; $i++) {
            $username = $faker->unique()->userName();
            $email = $username . "@" . $faker->freeEmailDomain();
            $password = $username . "2024.";
            $role = $faker->randomElement(Role::cases())->toString();
            $image = $faker->fakeImg(dir: __DIR__ . "/../../public/img/users/", width: 640, height: 640, fullPath: false, text: strtoupper(substr($username, 0, 3)), backgroundColor: [$randomColor(), $randomColor(), $randomColor()]);
            (new UserEntity)
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setRole($role)
                ->setImage($image)
                ->create();
        }
    }

    public static function  resetTableUsers(): void
    {
        parent::executeQuery("DELETE FROM users", "Failed deleting table users");
        parent::executeQuery("ALTER TABLE users AUTO_INCREMENT = 1", "Failed reset auto increment on table users");
    }

    public static function isFieldUnique(string $field, string $value, ?int $id = null): bool
    {
        $idQuery = is_null($id) ? "" : " AND id <> :i";
        $placeholders = is_null($id) ? [":v" => $value] : [":v" => $value, ":i" => $id];
        return !parent::executeQuery(
            "SELECT count(*) FROM users WHERE $field = :v$idQuery",
            "Failed checking if is unique $field",
            $placeholders
        )->fetchColumn();
    }

    public static function getPasswordByUniqueField(string $uniqueField, string $value): string|false
    {
        return parent::executeQuery(
            "SELECT password FROM users WHERE $uniqueField = :v",
            "Failed retraiving password with $uniqueField",
            [
                ":v" => $value
            ]
        )->fetchColumn();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole(?string $role = null)
    {
        $this->role = is_null($role) ? Role::User->toString() : $role;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage(?string $image = null)
    {
        $this->image = "img/users/" . (is_null($image) ? ImageConstants::DEFAULT_IMAGE_FILENAME : $image);

        return $this;
    }
}

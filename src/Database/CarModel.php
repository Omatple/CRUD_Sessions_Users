<?php

namespace App\Database;

use App\Utils\CarBrand;
use App\Utils\ImageConstants;
use \Faker\Factory;
use \Mmo\Faker\FakeimgProvider;

require __DIR__ . "/../../vendor/autoload.php";

class CarModel extends QueryExecutor
{
    private int $id;
    private string $name;
    private string $brand;
    private int $horsepower;
    private string $image;

    public static function fetchAllCars(): array
    {
        return parent::executeQuery(
            "SELECT * FROM cars",
            "Failed to retrieve cars"
        )->fetchAll();
    }

    public function saveCar(): void
    {
        parent::executeQuery(
            "INSERT INTO cars (name, brand, horsepower, image) VALUES (:name, :brand, :hp, :img)",
            "Failed to create car '{$this->name}'",
            [
                ":name" => $this->name,
                ":brand" => $this->brand,
                ":hp" => $this->horsepower,
                ":img" => $this->image,
            ]
        );
    }

    public function updateCar(int $id): void
    {
        parent::executeQuery(
            "UPDATE cars SET name = :name, brand = :brand, horsepower = :hp, image = :img WHERE id = :id",
            "Failed to update car with ID '$id'",
            [
                ":id" => $id,
                ":name" => $this->name,
                ":brand" => $this->brand,
                ":hp" => $this->horsepower,
                ":img" => $this->image,
            ]
        );
    }

    public static function resetCarImageToDefault(int $id): void
    {
        parent::executeQuery(
            "UPDATE cars SET image = :img WHERE id = :id",
            "Failed to reset image for car with ID '$id'",
            [
                ":id" => $id,
                ":img" => "img/" . ImageConstants::DEFAULT_FILENAME,
            ]
        );
    }

    public static function generateFakeCars(): void
    {
        $carCount = 20;
        $faker = Factory::create("es_ES");
        $faker->addProvider(new FakeimgProvider($faker));

        $randomColor = fn(): int => random_int(0, 255);

        for ($i = 0; $i < $carCount; $i++) {
            $carName = ucwords($faker->words(random_int(1, 4), true));
            $carBrand = $faker->randomElement(CarBrand::cases())->getName();
            $carHorsepower = random_int(49, 600);
            $text = strtoupper(implode("", array_map(fn($word) => substr($word, 0, 1), explode(" ", $carName))));
            $carImage = $faker->fakeImg(
                dir: __DIR__ . "/../../public/cars/img/",
                width: 640,
                height: 640,
                fullPath: false,
                text: $text,
                backgroundColor: [$randomColor(), $randomColor(), $randomColor()]
            );

            (new CarModel)
                ->setName($carName)
                ->setBrand($carBrand)
                ->setHorsepower($carHorsepower)
                ->setImage($carImage)
                ->saveCar();
        }
    }

    public static function clearCarsTable(): void
    {
        parent::executeQuery("DELETE FROM cars", "Failed to clear cars table");
        parent::executeQuery("ALTER TABLE cars AUTO_INCREMENT = 1", "Failed to reset auto-increment on cars table");
    }

    public static function deleteCar(int $id): void
    {
        parent::executeQuery(
            "DELETE FROM cars WHERE id = :id",
            "Failed to delete car with ID '$id'",
            [
                ":id" => $id,
            ]
        );
    }

    public static function isCarUnique(string $name, string $brand, int $horsepower, ?int $id = null): bool
    {
        $idCondition = is_null($id) ? "" : " AND id <> :id";
        $parameters = is_null($id)
            ? [":name" => $name, ":brand" => $brand, ":hp" => $horsepower]
            : [":id" => $id, ":name" => $name, ":brand" => $brand, ":hp" => $horsepower];

        return !parent::executeQuery(
            "SELECT count(*) FROM cars WHERE name = :name AND brand = :brand AND horsepower = :hp$idCondition",
            "Failed to verify car uniqueness",
            $parameters
        )->fetchColumn();
    }

    public static function getCarByField(string $field, string $value): false|array
    {
        return parent::executeQuery(
            "SELECT * FROM cars WHERE $field = :value",
            "Failed to retrieve car with field '$field'",
            [
                ":value" => $value,
            ]
        )->fetch();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getHorsepower(): int
    {
        return $this->horsepower;
    }

    public function setHorsepower(int $horsepower): self
    {
        $this->horsepower = $horsepower;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = "img/" . $image;
        return $this;
    }
}

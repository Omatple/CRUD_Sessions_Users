<?php

namespace App\Database;

use App\Utils\Brand;
use \Faker\Factory;
use \Mmo\Faker\FakeimgProvider;

require __DIR__ . "/../../vendor/autoload.php";
class CarEntity extends QueryExecutor
{
    private int $id;
    private string $name;
    private string $brand;
    private int $horsepower;
    private string $image;

    public static function read(): array
    {
        return parent::executeQuery(
            "SELECT * FROM cars",
            "Failed retraiving cars"
        )->fetchAll();
    }

    public function create(): void
    {
        parent::executeQuery(
            "INSERT INTO cars (name, brand, horsepower, image) VALUES (:n, :b, :h, :i)",
            "Failed to create car '{$this->name}'",
            [
                ":n" => $this->name,
                ":b" => $this->brand,
                ":h" => $this->horsepower,
                ":i" => $this->image,
            ]
        );
    }

    public static function generateFakesCars(): void
    {
        $amount = 20;
        $faker = Factory::create("es_ES");
        $faker->addProvider(new FakeimgProvider($faker));
        $randomColor = fn(): int => random_int(0, 255);
        for ($i = 0; $i < $amount; $i++) {
            $name = $faker->words(random_int(1, 4), true);
            $brand = $faker->randomElement(Brand::cases())->toString();
            $horsepower = random_int(49, 600);
            $text = strtoupper(implode("", array_map(fn($word) => substr($word, 0, 1), explode(" ", $name))));
            $image = $faker->fakeImg(dir: __DIR__ . "/../../public/img/cars/", width: 640, height: 640, fullPath: false, text: $text, backgroundColor: [$randomColor(), $randomColor(), $randomColor()]);
            (new CarEntity)
                ->setName($name)
                ->setBrand($brand)
                ->setHorsepower($horsepower)
                ->setImage($image)
                ->create();
        }
    }

    public static function resetTableCars(): void
    {
        parent::executeQuery("DELETE FROM cars", "Failed deleting table cars");
        parent::executeQuery("ALTER TABLE cars AUTO_INCREMENT = 1", "Failed reset auto increment on table cars");
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
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get the value of horsepower
     */
    public function getHorsepower()
    {
        return $this->horsepower;
    }

    /**
     * Set the value of horsepower
     *
     * @return  self
     */
    public function setHorsepower($horsepower)
    {
        $this->horsepower = $horsepower;

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
    public function setImage($image)
    {
        $this->image = "img/cars/" . $image;

        return $this;
    }
}

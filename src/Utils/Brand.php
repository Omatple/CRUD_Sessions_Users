<?php

namespace App\Utils;

enum Brand: string
{
    case Toyota = 'Toyota';
    case Ford = 'Ford';
    case Chevrolet = 'Chevrolet';
    case Honda = 'Honda';
    case Nissan = 'Nissan';
    case BMW = 'BMW';
    case MercedesBenz = 'Mercedes Benz';
    case Audi = 'Audi';
    case Volkswagen = 'Volkswagen';
    case Hyundai = 'Hyundai';
    case Kia = 'Kia';
    case Subaru = 'Subaru';
    case Mazda = 'Mazda';
    case Tesla = 'Tesla';
    case Lexus = 'Lexus';
    case Jaguar = 'Jaguar';
    case LandRover = 'Land Rover';
    case Porsche = 'Porsche';
    case Ferrari = 'Ferrari';
    case Lamborghini = 'Lamborghini';
    case Bugatti = 'Bugatti';
    case AstonMartin = 'Aston Martin';
    case Maserati = 'Maserati';
    case AlfaRomeo = 'Alfa Romeo';
    case Peugeot = 'Peugeot';
    case Citroën = 'Citroën';
    case Renault = 'Renault';
    case Fiat = 'Fiat';
    case Volvo = 'Volvo';
    case Saab = 'Saab';
    case Suzuki = 'Suzuki';
    case Mitsubishi = 'Mitsubishi';
    case Infiniti = 'Infiniti';
    case Acura = 'Acura';
    case Génesis = 'Génesis';
    case RollsRoyce = 'Rolls Royce';
    case Bentley = 'Bentley';
    case Mini = 'Mini';
    case Škoda = 'Škoda';
    case SEAT = 'SEAT';
    case McLaren = 'McLaren';
    case Dodge = 'Dodge';
    case Jeep = 'Jeep';
    case Ram = 'Ram';
    case Chrysler = 'Chrysler';
    case Buick = 'Buick';
    case Cadillac = 'Cadillac';
    case GMC = 'GMC';
    case Lincoln = 'Lincoln';
    case Opel = 'Opel';
    case Vauxhall = 'Vauxhall';
    case Dacia = 'Dacia';
    case Mahindra = 'Mahindra';
    case Tata = 'Tata';
    case Proton = 'Proton';
    case Geely = 'Geely';
    case Chery = 'Chery';
    case BYD = 'BYD';
    case GreatWall = 'Great Wall';
    case Foton = 'Foton';
    case Haval = 'Haval';
    case MG = 'MG';
    case Roewe = 'Roewe';
    case Luxgen = 'Luxgen';
    case Isuzu = 'Isuzu';
    case Scania = 'Scania';
    case Iveco = 'Iveco';
    case MAN = 'MAN';
    case Hino = 'Hino';
    case Peterbilt = 'Peterbilt';
    case Kenworth = 'Kenworth';
    case TataDaewoo = 'Tata Daewoo';
    case Daihatsu = 'Daihatsu';
    case SsangYong = 'SsangYong';

    public function toString(): string
    {
        return $this->value;
    }
}

<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Car;

class CarFixtures extends Fixture {

    public function load(ObjectManager $manager): void{
        $c = [
            1 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            2 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            3 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            4 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            5 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            6 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            7 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            8 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            9 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            10 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            11 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            12 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            13 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            14 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            15 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            16 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            17 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            18 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            19 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            20 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            21 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            22 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            23 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            24 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            25 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            26 => [
                'name'=> 'Opel corsa',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            27 => [
                'name'=> 'Peugeot 106',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            28 => [
                'name'=> 'Toyota Yaris',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            29 => [
                'name'=> 'Citroën C1',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ],
            30 => [
                'name'=> 'Citroën 2ch',
                'nbSeats' => 5,
                'nbDoors' => 5,
                'cost' => 20000
            ]
        ];
        foreach ($c as $key => $value) {
            $car = new Car();
            $car->setName($value['name']);
            $car->setNbSeats($value['nbSeats']);
            $car->setNbDoors($value['nbDoors']);
            $car->setCost($value['cost']);
            $manager->persist($car);
        }
        $manager->flush();
    }
}
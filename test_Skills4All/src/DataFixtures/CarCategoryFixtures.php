<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CarCategory;
use App\Entity\Car;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CarCategoryFixtures extends Fixture implements DependentFixtureInterface{

    public function load(ObjectManager $manager): void{
        $c = [
            1 => [
                'name'=> 'SUV',
                'car_id' => 1
            ],
            2 => [
                'name'=> 'cabriolet',
                'car_id' => 2
            ],
            3 => [
                'name'=> 'SUV',
                'car_id' => 3
            ],
            4 => [
                'name'=> 'cabriolet',
                'car_id' => 4
            ],
            5 => [
                'name'=> 'SUV',
                'car_id' => 5
            ],
            6 => [
                'name'=> 'cabriolet',
                'car_id' => 6
            ],
            7 => [
                'name'=> 'SUV',
                'car_id' => 7
            ],
            8 => [
                'name'=> 'cabriolet',
                'car_id' => 8
            ],
            9 => [
                'name'=> 'SUV',
                'car_id' => 9
            ],
            10 => [
                'name'=> 'cabriolet',
                'car_id' => 10
            ],
            11 => [
                'name'=> 'SUV',
                'car_id' => 2
            ],
            12 => [
                'name'=> 'cabriolet',
                'car_id' => 3
            ],
            13 => [
                'name'=> 'SUV',
                'car_id' => 4
            ],
            14 => [
                'name'=> 'cabriolet',
                'car_id' => 5
            ]
        ];
        foreach ($c as $key => $value) {
            $car =$manager->getRepository(Car:: class)->find($value['car_id']);
            $carCategory = new CarCategory();
            $carCategory->setName($value['name']);
            $carCategory->setCarId($car);
            $manager->persist($carCategory);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CarFixtures::class,
        ];
    }
}
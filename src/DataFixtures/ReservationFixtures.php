<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ReservationFixtures extends Fixture implements DependentFixtureInterface{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i <=5 ; $i++) { 
            $user = $this->getReference("User". random_int(1,5));
            $property = $this->getReference("Property". random_int(1,5));
            $reservation = (new Reservation())
            ->setCheckIn($faker->dateTime())
            ->setCheckOut($faker->dateTime())
            ->setTotalPrice($faker->numberBetween(600, 1500))
            ->setStatus([])
            ->setProperty($property)
            ->setUser($user)
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));

            $manager->persist($reservation); 
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PropertyFixtures::class,
            UserFixtures::class
        ];
        
    }
}
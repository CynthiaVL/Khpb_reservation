<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AddressFixtures extends Fixture {
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i <= 5 ; $i++) { 
            $address = (new Address())
            ->setStreet($faker->streetName())
            ->setCity($faker->city())
            ->setPostalCode($faker->numberBetween(01000,99999))
            ->setCountry($faker->country());
            
            $manager->persist($address);
            $this->addReference("Address". $i, $address);
        }

        $manager->flush();
    }

}
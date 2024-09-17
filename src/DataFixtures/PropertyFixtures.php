<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PropertyFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=1; $i<=5 ; $i++) {
            $address = $this->getReference("Address". random_int(1,5));

            $property = (new Property())
            ->setTitle($faker->title())
            ->setDescription($faker->text())
            ->setType("Studio")
            ->setMeter(random_int(20,60))
            ->setMaxGuest(random_int(2,6))
            ->setOnline(true)
            ->setMinDay(7)
            ->setAddress($address)
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            
            $manager->persist($property);
            $this->addReference("Property". $i, $property);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [AddressFixtures::class];
    }
}
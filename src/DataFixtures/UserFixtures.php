<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i <= 5 ; $i++) { 
            $address = $this->getReference("Address". random_int(1,5));

            $user = (new User())
            ->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setEmail($faker->unique()->email())
            ->setPassword($faker->password())
            ->setBirthdate($faker->dateTime())
            ->setPhoneNumber($faker->phoneNumber())
            ->setRoles(["USER"])
            ->setAddress($address)
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            
            $manager->persist($user);
            $this->addReference("User". $i, $user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [AddressFixtures::class];
    }
}
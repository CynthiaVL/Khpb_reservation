<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class OwnerFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i <= 5 ; $i++) { 

            $property = $this->getReference("Property". random_int(1,5));
            $owner = (new Owner)
            ->setLastName($faker->lastName())
            ->setRib($faker->text);
            $numberOfProperties = random_int(1, 3); // Chaque propriétaire peut avoir entre 1 et 3 propriétés
            for ($j = 1; $j <= $numberOfProperties; $j++) {
                $propertyReference = 'Property' . (($i - 1) * 3 + $j); // Associer les propriétés en séquence
                if ($this->hasReference($propertyReference)) {
                    $property = $this->getReference($propertyReference);
                    $property->setOwner($owner); // Définir l'owner sur la propriété
                }
            }

            $manager->persist($owner);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [PropertyFixtures::class];
    }
}
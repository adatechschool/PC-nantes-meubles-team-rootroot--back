<?php

namespace App\DataFixtures;

use App\Entity\Meubles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MeublesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {
            $meuble = new Meubles();
            $meuble->setCategory($i)
                ->setPrice(130)
                ->setTitle("Armoire de Mamie")
                ->setDescription("Magnifique armoire en merisier")
                ->setDimensionId($i);
            $manager->persist($meuble);
        }

        $manager->flush();
    }
}
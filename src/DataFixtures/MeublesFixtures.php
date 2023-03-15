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

        for ($i=0; $i<5; $i++){
            $meuble = new Meubles();
            $meuble ->setType("canape")
                    ->setPrix(130)
                    ->setCouleur("noir")
                    ->setDescription("c tré bo");
            $manager->persist($meuble);
        }
        
        $manager->flush();
    }
}

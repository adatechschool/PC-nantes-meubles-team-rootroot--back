<?php

namespace App\DataFixtures;

use App\Entity\Colors;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ColorsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $colorList = ['Red', 'White', 'Black', 'Gray', 'Dark wood', 'Light wood'];
        for ($i = 0; $i < count($colorList); $i++) {
            $color = new Colors();
            $color->setColor($colorList[$i]);


            $manager->persist($color);
        }

        $manager->flush();
    }
}
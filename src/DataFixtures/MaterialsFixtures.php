<?php

namespace App\DataFixtures;

use App\Entity\Materials;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaterialsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $materialList = ['Wood', 'Plastic', 'Metal', 'Glass'];
        for ($i = 0; $i < count($materialList); $i++) {
            $material = new Materials();
            $material->setMaterial($materialList[$i])
                ->setMeubleId(1);

            $manager->persist($material);
        }
        $manager->flush();
    }
}

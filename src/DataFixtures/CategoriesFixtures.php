<?php

namespace App\DataFixtures;

use ApiPlatform\Api\QueryParameterValidator\Validator\Length;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $categoryList = ['Table', 'Chair', 'Bed', 'Sofa', 'Storage cabinet'];
        for ($i = 0; $i < count($categoryList); $i++) {
            $category = new Categories();
            $category->setCategory($categoryList[$i]);

            $manager->persist($category);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_SUB_CATEGORY = 'CATEGORY_SUB_CATEGORY';

    public function load(ObjectManager $manager): void
    {
        $mainCategory = new Category();
        $mainCategory->setTitle('Main Category');
        $manager->persist($mainCategory);

        $category = new Category();
        $category->setTitle('Sous Category');
        $category->setParent($mainCategory);
        $category->setDescription('Lorem');
        $manager->persist($category);
        $this->addReference(self::CATEGORY_SUB_CATEGORY, $category);

        for ($i=1; $i <=50 ; $i++) { 

            $category = new Category();
            $category->setTitle('Sous Category'.$i);
            $category->setParent($mainCategory);
            $category->setDescription('Lorem');
            $manager->persist($category);
        }

        $manager->flush();
    }
}

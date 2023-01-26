<?php

namespace App\DataFixtures;

use App\Entity\Mark;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCT_DONKEY_PELUCHE = 'PRODUCT_DONKEY_PELUCHE';

    public function load(ObjectManager $manager): void
    {   
        $products = [];
        for ($i=1 ; $i <= 50; $i++) { 
            $product = new Product();
            $product->setName('Super jouet'.$i);
            $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_SUB_CATEGORY));
            $product->setPrice(mt_rand(1, 1500));
            $manager->persist($product);
        }
        $products[] = $product;
        
        $this->addReference(self::PRODUCT_DONKEY_PELUCHE, $product);

        
        /* foreach ($products as $product) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $mark = new Mark();
                $mark->setMark(mt_rand(1, 5))
                    // ->setUser($users[mt_rand(0, count($users) - 1)])
                    ->setProduct($product);

                $manager->persist($mark);
            }
        } */

        $manager->flush();
    }
    

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}

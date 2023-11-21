<?php

namespace App\DataFixtures;

use App\Entity\Questionnaire\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_REFERENCE = 'product';

    public function load(ObjectManager $manager): void
    {
        $products = [
            'Sildenafil 50mg',
            'Sildenafil 100mg',
            'Tadalafil 10mg',
            'Tadalafil 20mg',
        ];

        foreach ($products as $index => $productName) {
            $product = new Product();
            $product->setName($productName);
            $manager->persist($product);
            $this->addReference(self::PRODUCT_REFERENCE.'_'.$index, $product);
        }

        $manager->flush();
    }
}

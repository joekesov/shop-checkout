<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach($this->getData() as $productData) {
            $product = new Product();
            $product
                ->setSku($productData['sku'])
                ->setPrice($productData['price']);

            $manager->persist($product);
            $this->addReference($productData['reference'], $product);
        }

        $manager->flush();
    }

    private function getData()
    {
        return [
            [
                'reference' => 'product_01',
                'sku' => 'A',
                'price' => 50,
            ],
            [
                'reference' => 'product_02',
                'sku' => 'B',
                'price' => 30,
            ],
            [
                'reference' => 'product_03',
                'sku' => 'C',
                'price' => 20,
            ],
            [
                'reference' => 'product_04',
                'sku' => 'D',
                'price' => 10,
            ],

        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        foreach($this->getData() as $itemData) {
            $item = new Item();
            $item
                ->setSku($itemData['sku'])
                ->setPrice($itemData['price']);

            $manager->persist($item);
            $this->addReference($itemData['reference'], $item);
        }

        $manager->flush();
    }

    private function getData()
    {
        return [
            [
                'reference' => 'item_01',
                'sku' => 'A',
                'price' => 50,
            ],
            [
                'reference' => 'item_02',
                'sku' => 'B',
                'price' => 30,
            ],
            [
                'reference' => 'item_03',
                'sku' => 'C',
                'price' => 20,
            ],
            [
                'reference' => 'item_04',
                'sku' => 'D',
                'price' => 10,
            ],

        ];
    }
}

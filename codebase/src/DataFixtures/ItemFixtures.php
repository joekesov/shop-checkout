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


        foreach(range('A','E') as $letter) {
            $item = new Item();
            $item
                ->setSku($letter)
                ->setPrice(20);

            $manager->persist($item);
        }

        $manager->flush();
    }
}

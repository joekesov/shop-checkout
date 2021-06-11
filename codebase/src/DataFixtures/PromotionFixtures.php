<?php

namespace App\DataFixtures;

use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromotionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach(range('A','E') as $letter) {
//            $item = new Promotion();
//            $item
//                ->setSku($letter)
//                ->setPrice(20);
//
//            $manager->persist($item);
        }

        $manager->flush();
    }
}

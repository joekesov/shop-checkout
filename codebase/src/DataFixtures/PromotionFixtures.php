<?php

namespace App\DataFixtures;

use App\DataFixtures\ItemFixtures;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach($this->getData() as $promotionData) {
            $item = $this->getReference($promotionData['itemRef']);
            $promotion = new Promotion();
            $promotion->setIsActive(true)
                ->setQuantity($promotionData['quantity'])
                ->setPrice($promotionData['price'])
                ->setItem($item);

            $manager->persist($promotion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ItemFixtures::class,
        ];
    }

    private function getData(): array
    {
        return [
            [
                'quantity' => 4,
                'price' => 160,
                'itemRef' => 'item_01'
            ],
            [
                'quantity' => 3,
                'price' => 130,
                'itemRef' => 'item_01'
            ],
            [
                'quantity' => 2,
                'price' => 98,
                'itemRef' => 'item_01'
            ],
            [
                'quantity' => 2,
                'price' => 45,
                'itemRef' => 'item_02'
            ],
            [
                'quantity' => 3,
                'price' => 50,
                'itemRef' => 'item_03'
            ],
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\DataFixtures\ProductFixtures;
use App\Entity\Promotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PromotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach($this->getData() as $promotionData) {
            $product = $this->getReference($promotionData['itemRef']);
            $promotion = new Promotion();
            $promotion->setIsActive(true)
                ->setQuantity($promotionData['quantity'])
                ->setPrice($promotionData['price'])
                ->setProduct($product);

            $manager->persist($promotion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }

    private function getData(): array
    {
        return [
            [
                'quantity' => 4,
                'price' => 160,
                'itemRef' => 'product_01'
            ],
            [
                'quantity' => 3,
                'price' => 130,
                'itemRef' => 'product_01'
            ],
            [
                'quantity' => 2,
                'price' => 98,
                'itemRef' => 'product_01'
            ],
            [
                'quantity' => 2,
                'price' => 45,
                'itemRef' => 'product_02'
            ],
            [
                'quantity' => 3,
                'price' => 50,
                'itemRef' => 'product_03'
            ],
        ];
    }
}

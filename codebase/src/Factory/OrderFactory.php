<?php


namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Item;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Item $item
     *
     * @return OrderItem
     */
    public function createItem(Item $item): OrderItem
    {
        $item = new OrderItem();
        $item->setProduct($item);
        $item->setQuantity(1);

        return $item;
    }
}
<?php


namespace App\Manager;

use App\Entity\Order;
use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CartManager
 * @package App\Manager
 */
class CartManager
{
    /**
     * @var CartSessionStorage
     */
    private $cartSessionStorage;

    /**
     * @var OrderFactory
     */
    private $cartFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CartManager constructor.
     *
     * @param CartSessionStorage $cartStorage
     * @param OrderFactory $orderFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CartSessionStorage $cartStorage,
        OrderFactory $orderFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->cartSessionStorage = $cartStorage;
        $this->cartFactory = $orderFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the current cart.
     *
     * @return Order
     */
    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart) {
            $cart = $this->cartFactory->create();
        }

        return $cart;
    }

    /**
     * Persists the cart in database and session.
     *
     * @param Order $cart
     */
    public function save(Order $cart): void
    {
        // Persist in database
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
        // Persist in session
        $this->cartSessionStorage->setCart($cart);
    }

    public function checkout(Order $cart): void
    {
        $invoice = new Invoice();
        $invoice->setOrderRef($cart);

        foreach ($cart->getOrderItems() as $orderItem) {
            $product = $orderItem->getProduct();
            $promotions = $product->getPromotions();

            $itemQuantity = $orderItem->getQuantity();
            foreach ($promotions as $promotion) {
                while ($promotion->getQuantity() <= $itemQuantity) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->setProduct($orderItem->getProduct())
                        ->setPromotion($promotion)
                        ->setQuantity($promotion->getQuantity())
                        ->setPrice($promotion->getPrice());

                    $invoice->addInvoiceItem($invoiceItem);

                    $itemQuantity -= $promotion->getQuantity();
                }
            }

            if (empty($itemQuantity)) {
                continue;
            }

            $invoiceItem = new InvoiceItem();
            $invoiceItem->setProduct($orderItem->getProduct())
                ->setQuantity($itemQuantity)
                ->setPrice($itemQuantity * $product->getPrice());

            $invoice->addInvoiceItem($invoiceItem);
        }

        $cart->addInvoice($invoice);
        $cart->setStatus(Order::STATUS_CHECKOUT);

    }
}
<?php


namespace App\Presentation\Order\Form\EventListener;

use App\Entity\Order;
use App\Entity\Invoice;
use App\Entity\InvoiceItem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CheckoutCartListener implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    /**
     * Removes all items from the cart when the clear button is clicked.
     *
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if (!$cart instanceof Order) {
            return;
        }

        // Is the clear button clicked?
        if (!$form->get('checkout')->isClicked()) {
            return;
        }

        if ($cart->getStatus() != Order::STATUS_CART) {
            return;
        }

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
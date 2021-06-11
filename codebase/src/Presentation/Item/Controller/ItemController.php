<?php


namespace App\Presentation\Item\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Presentation\Order\Form\AddToCartType;
use App\Manager\CartManager;

class ItemController extends AbstractController
{
    public function index(Item $item, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();
            $orderItem->setItem($item);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addOrderItem($orderItem)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            return $this->redirectToRoute('app_item_detail', ['id' => $item->getId()]);
        }

        return $this->render('item/detail.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }
}
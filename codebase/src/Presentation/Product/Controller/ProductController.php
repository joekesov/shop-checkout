<?php


namespace App\Presentation\Product\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Presentation\Order\Form\AddToCartType;
use App\Manager\CartManager;

class ProductController extends AbstractController
{
    public function index(Product $product, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();
            $orderItem->setProduct($product);

            $cart = $cartManager->getCurrentCart();
            $cart
                ->addOrderItem($orderItem)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            $this->addFlash(
                'notice',
                'Cart was updated successfully!'
            );

            return $this->redirectToRoute('app_product_detail', ['id' => $product->getId()]);
        }

        return $this->render('item/detail.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
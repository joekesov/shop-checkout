<?php


namespace App\Presentation\Order\Controller;

use App\Entity\Order;
use App\Presentation\Order\Form\CartType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            $flashMessage = 'Cart was updated successfully!';
            $redirectTo = 'app_cart';
            $redirectParams = [];

            if ($form->get('checkout')->isClicked() && $cart->getStatus() == Order::STATUS_CHECKOUT) {
                $flashMessage = 'Successfully checked out your order!';
                $redirectTo = 'app_invoice_view';
                $redirectParams['id'] = $cart->getInvoices()->first()->getId();
            }

            $this->addFlash('notice', $flashMessage);

            return $this->redirectToRoute($redirectTo, $redirectParams);
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

}
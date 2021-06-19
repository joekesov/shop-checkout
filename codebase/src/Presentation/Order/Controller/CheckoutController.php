<?php


namespace App\Presentation\Order\Controller;

use App\Entity\Invoice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    public function index(Invoice $invoice)
    {


        return $this->render('cart/invoice.html.twig', [
            'invoice' => $invoice,
        ]);
    }
}
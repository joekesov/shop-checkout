<?php


namespace App\Presentation\Home\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'items' => $products,
        ]);
    }
}
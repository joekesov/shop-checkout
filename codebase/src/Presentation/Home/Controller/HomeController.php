<?php


namespace App\Presentation\Home\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Item;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Item::class);
        $items = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'items' => $items,
        ]);
    }
}
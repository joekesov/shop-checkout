<?php


namespace App\Presentation\Item\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    public function index(Item $item): Response
    {
        return $this->render('item/detail.html.twig', [
            'item' => $item,
        ]);
    }
}
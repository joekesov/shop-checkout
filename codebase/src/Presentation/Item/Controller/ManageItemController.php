<?php


namespace App\Presentation\Item\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Item;
use App\Presentation\Item\Form\ItemType;

class ManageItemController extends AbstractController
{
    public function showList(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $items = $repository->findAll();

        return $this->render('item/show_list.html.twig', [
            'items' => $items,
        ]);
    }

    public function createItem(Request $request): Response
    {
        $item = new Item();

        return $this->handleSave(
            $request,
            $item,
            ItemType::class,
            'item/create.html.twig',
            $this->generateUrl('app_item_list', [])
        );
    }

    public function showItem(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    public function editItem(Item $item, Request $request): Response
    {
        return $this->handleSave(
            $request,
            $item,
            ItemType::class,
            'item/edit.html.twig',
            $this->generateUrl('app_item_show', ['id' => $item->getId()])
        );
    }
}
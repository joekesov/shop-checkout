<?php


namespace App\Presentation\Item\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Item;
use App\Presentation\Item\Form\ItemType;
use App\Repository\ItemRepository;

class ItemController extends AbstractController
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

        return $this->handleSaveItem($item, $request, 'item/create.html.twig');
    }

    public function showItem(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    public function editItem(Item $item, Request $request): Response
    {
        return $this->handleSaveItem($item, $request, 'item/edit.html.twig');
    }

    private function handleSaveItem(Item $item, Request $request, string $template): Response
    {
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $item = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('app_item_list');
        }

        return $this->render($template, [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }
}
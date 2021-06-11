<?php


namespace App\Presentation\Price\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Presentation\Price\Form\PriceType;
use App\Entity\Price;
use App\Entity\Item;

class PriceController extends AbstractController
{
    public function createPrice(Item $item, Request $request): Response
    {
        $price = new Price();
        $price->setItem($item);

        return $this->handleSavePrice($price, $request, 'item/create.html.twig');
    }

    public function editPrice(Price $price, Request $request): Response
    {
        return $this->handleSavePrice($price, $request, 'price/edit.html.twig');
    }

    private function handleSavePrice(Price $price, Request $request, string $template)
    {
        $form = $this->createForm(PriceType::class, $price);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $price = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($price);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('app_item_show', ['id' => $price->getItem()->getId()]);
        }

        return $this->render($template, [
            'price' => $price,
            'form' => $form->createView(),
        ]);
    }
}
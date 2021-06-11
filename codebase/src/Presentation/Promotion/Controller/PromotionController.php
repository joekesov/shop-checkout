<?php


namespace App\Presentation\Promotion\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Item;
use App\Entity\Promotion;
use App\Presentation\Promotion\Form\PromotionType;

class PromotionController extends AbstractController
{
    public function create(Item $item, Request $request): Response
    {
        $promotion = new Promotion();
        $promotion->setItem($item);

        return $this->handleSave(
            $request,
            $promotion,
            PromotionType::class,
            'promotion/create.html.twig',
            $this->generateUrl('app_item_show', ['id' => $item->getId()])
        );
    }

    public function view(Promotion $promotion, Request $request): Response
    {

    }

    public function edit(Promotion $promotion, Request $request): Response
    {
        return $this->handleSave(
            $request,
            $promotion,
            PromotionType::class,
            'promotion/edit.html.twig',
            $this->generateUrl('app_item_show', ['id' => $promotion->getItem()->getId()])
        );
    }

    public function delete(Promotion $promotion, Request $request): Response
    {

    }

//    private function handleSave(Promotion $promotion, Request $request, string $template)
//    {
//        $form = $this->createForm(PromotionType::class, $promotion);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            // $form->getData() holds the submitted values
//            // but, the original `$task` variable has also been updated
//            $promotion = $form->getData();
//
//            // ... perform some action, such as saving the task to the database
//            // for example, if Task is a Doctrine entity, save it!
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($promotion);
//            $entityManager->flush();
//
//            $this->addFlash(
//                'notice',
//                'Your changes were saved!'
//            );
//
//            return $this->redirectToRoute('app_item_show', ['id' => $promotion->getItem()->getId()]);
//        }
//
//        return $this->render($template, [
//            'promotion' => $promotion,
//            'form' => $form->createView(),
//        ]);
//    }
}
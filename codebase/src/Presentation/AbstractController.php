<?php


namespace App\Presentation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\AbstractEntity;

abstract class AbstractController extends BaseAbstractController
{
    protected function handleSave(Request $request, AbstractEntity $entity,  string $formTypeClassName, string $template, string $redirectTo)
    {
        $form = $this->createForm($formTypeClassName, $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entity = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect($redirectTo);
        }

        return $this->render($template, [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }
}
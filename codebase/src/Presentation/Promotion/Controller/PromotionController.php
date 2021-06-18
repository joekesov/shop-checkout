<?php


namespace App\Presentation\Promotion\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Presentation\Promotion\Form\PromotionType;

class PromotionController extends AbstractController
{
    public function create(Product $product, Request $request): Response
    {
        $promotion = new Promotion();
        $promotion->setProduct($product);

        return $this->handleSave(
            $request,
            $promotion,
            PromotionType::class,
            'promotion/create.html.twig',
            $this->generateUrl('app_product_view', ['id' => $product->getId()])
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
            $this->generateUrl('app_product_view', ['id' => $promotion->getProduct()->getId()])
        );
    }

    public function delete(Promotion $promotion, Request $request): Response
    {

    }
}
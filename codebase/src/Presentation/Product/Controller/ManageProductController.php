<?php


namespace App\Presentation\Product\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Presentation\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use App\Presentation\Product\Form\ProductType;

class ManageProductController extends AbstractController
{
    public function showList(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('item/show_list.html.twig', [
            'items' => $products,
        ]);
    }

    public function create(Request $request): Response
    {
        $product = new Product();

        return $this->handleSave(
            $request,
            $product,
            ProductType::class,
            'item/create.html.twig',
            $this->generateUrl('app_products_list', [])
        );
    }

    public function view(Product $product): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $product,
        ]);
    }

    public function edit(Product $product, Request $request): Response
    {
        return $this->handleSave(
            $request,
            $product,
            ProductType::class,
            'item/edit.html.twig',
            $this->generateUrl('app_product_view', ['id' => $product->getId()])
        );
    }
}
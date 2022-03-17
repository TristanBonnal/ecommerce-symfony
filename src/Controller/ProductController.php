<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Model\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/articles', name: 'product')]
    public function index(ProductRepository $repository, Request $request): Response
    {
       
        // Si recherche exécutée, $products contiendra les résultats filtrés
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $repository->findWithSearch($search);
        } else {
            $products = $repository->findAll();
        }

        
        return $this->renderForm('product/index.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }

    #[Route('/articles/{slug}', name: 'product_show')]
    public function show(ProductRepository $repository, string $slug): Response
    {
        $product = $repository->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('product');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}



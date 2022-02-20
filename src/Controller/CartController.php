<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Utils\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * Récupère le panier en session, puis récupère les objets produits de la bdd
     * et calcule les totaux
     *
     * @param Cart $cart
     * @param ProductRepository $repository
     * @return Response
     */
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart, ProductRepository $repository): Response
    {
        $cartProducts = [];
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cart->get() as $id => $quantity) {
            $currentProduct = $repository->find($id);
            $cartProducts[] = [
                'product' => $currentProduct,
                'quantity' => $quantity
            ];
            $totalQuantity += $quantity;
            $totalPrice += $currentProduct->getPrice() * $quantity;
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cartProducts,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice
        ]);
    }

    /**
     * Ajoute un article au panier (id du produit) et incrémente la quantitée (voir classe Cart)
     * @param Cart $cart
     * @param int $id
     * @return Repsonse
     */
    #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * Vide le panier entièrement
     *
     * @param Cart $cart
     * @return Response
     */
    #[Route('/panier/supprimer/', name: 'remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('product');
    }
}

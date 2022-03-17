<?php

namespace App\Controller;

use App\Model\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * Récupère un panier détaillé contenant des objets Products et les totaux de quantité et de prix 
     * 
     * @param Cart $cart
     * @return Response
     */
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cartProducts = $cart->getDetails();

        return $this->render('cart/index.html.twig', [
            'cart' => $cartProducts['products'],
            'totalQuantity' => $cartProducts['totals']['quantity'],
            'totalPrice' =>$cartProducts['totals']['price']
        ]);
    }

    /**
     * Ajoute un article au panier (id du produit) et incrémente la quantitée (voir classe Cart)
     * @param Cart $cart
     * @param int $id
     * @return Repsonse
     */
    #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * Réduit de 1 la quantité pour un article du panier
     * @param Cart $cart
     * @param int $id
     * @return Repsonse
     */
    #[Route('/panier/réduire/{id}', name: 'decrease_item')]
    public function decrease(Cart $cart, int $id): Response
    {
        $cart->decreaseItem($id);
        return $this->redirectToRoute('cart');
    }
    
    /**
     * Supprime une ligne d'articles du panier
     *
     * @param Cart $cart
     * @return Response
     */
    #[Route('/panier/supprimer/{id}', name: 'remove_cart_item')]
    public function removeItem(Cart $cart, int $id): Response
    {
        $cart->removeItem($id);
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

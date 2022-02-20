<?php
namespace App\Utils;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Permet de gérer un panier en session plutot que de tout implémenter dans le controller
 */
class Cart 
{
    private $session;

    public function __construct(SessionInterface $session, ProductRepository $repository)
    {
        $this->session = $session;
        $this->repository = $repository;
    }


    /**
     * Crée un tableau associatif id => quantité et le stocke en session
     *
     * @param int $id
     * @return void
     */
    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $this->session->set('cart', $cart);

    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        $this->session->remove('cart');
    }

    public function removeItem($id)
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        $this->session->set('cart', $cart);
    }

    public function decreaseItem($id)
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] < 2) {
            unset($cart[$id]);
        } else {
            $cart[$id]--;
        }
        $this->session->set('cart', $cart);
    }


    /**
     * Récupère le panier en session, puis récupère les objets produits de la bdd
     * et calcule les totaux
     *
     * @return array
     */
    public function getDetails(): array
    {
        $cartProducts = [
            'products' => [],
            'totals' => [
                'quantity' => 0,
                'price' => 0,
            ],
        ];

        $cart = $this->session->get('cart', []);
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $currentProduct = $this->repository->find($id);
                if ($currentProduct) {
                    $cartProducts['products'][] = [
                        'product' => $currentProduct,
                        'quantity' => $quantity
                    ];
                    $cartProducts['totals']['quantity'] += $quantity;
                    $cartProducts['totals']['price'] += $quantity * $currentProduct->getPrice();
                }
            }
        }
        return $cartProducts;
    }
}
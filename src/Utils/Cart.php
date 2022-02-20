<?php
namespace App\Utils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Permet de gérer un panier en session plutot que de tout implémenter dans le controller
 */
class Cart 
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
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
}
<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Models\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'order')]
    public function index(SessionInterface $session, Cart $cart, Request $request): Response
    {
        $user = $this->getUser();
        $cartProducts = $cart->getDetails();
        
        if (!$user->getAddresses()->getValues()) {      
            $session->set('order', 1);
            return $this->redirectToRoute('account_address_new');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $user     //Permet de passer l'utilisateur courant dans le tableau d'options du OrderType
        ]); 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'cart' => $cartProducts,
            'totalPrice' =>$cartProducts['totals']['price']
        ]);
    }
}

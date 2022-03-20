<?php

namespace App\Controller;

use App\Model\Cart;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/commande/checkout', name: 'checkout')]
    public function payment(Cart $cart): Response
    {
        // Récupération des produits du panier et formattage dans un tableau pour Stripe
        $products = $cart->getDetails()['products'];
        $productsForStripe = [];
        foreach ($products as $item) {
            $productsForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item['product']->getPrice(),
                    'product_data' => [
                        'name' => $item['product']->getName()
                    ]
                ],
                'quantity' => $item['quantity']
            ];
        }

        Stripe::setApiKey('sk_test_51Kb6uhClAQQ2TXfzOspWIks7VFbXX5e5ZTr5c4VCIQfNJATKvQZDHBODlaDkCnNmYntKUQLZK8YF4UbNPA5gMWzg00RHLAzE0G');
        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost:8000';
        
        // Création de la session Stripe avec les données du panier
        $checkout_session = Session::create([
            'line_items' => $productsForStripe,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/valide',
            'cancel_url' => $YOUR_DOMAIN . '/commande/echec',
        ]);

        return $this->redirect($checkout_session->url);
    }

    #[Route('/commande/valide', name: 'payment_success')]
    public function paymentSuccess() 
    {
        return $this->render('payment/success.html.twig');
    }

    #[Route('/commande/echec', name: 'payment_fail')]
    public function paymentFail() 
    {
        return $this->render('payment/fail.html.twig');
    }
}

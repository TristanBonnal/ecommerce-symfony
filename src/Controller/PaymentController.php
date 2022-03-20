<?php

namespace App\Controller;

use App\Model\Cart;
use App\Repository\OrderRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/commande/checkout/{reference}', name: 'checkout')]
    public function payment(Cart $cart, OrderRepository $repository, $reference): Response
    {
        // Récupération des produits de la dernière commande et formattage dans un tableau pour Stripe
        $order = $repository->findOneByReference($reference);
        if (!$order) {
            throw $this->createNotFoundException('Cette commande n\'existe pas');
        }
        
        dd($order);
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

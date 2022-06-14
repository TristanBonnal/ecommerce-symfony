<?php

namespace App\Controller;

use App\Entity\Order;
use App\Model\Cart;
use App\Repository\OrderRepository;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * Etape de vérification avant confirmation du paiement
     */
    #[Route('/commande/checkout/{reference}', name: 'checkout')]
    public function payment(OrderRepository $repository, $reference, EntityManagerInterface $em): Response
    {
        // Récupération des produits de la dernière commande et formattage dans un tableau pour Stripe
        $order = $repository->findOneByReference($reference);
        if (!$order) {
            throw $this->createNotFoundException('Cette commande n\'existe pas');
        }
        $products = $order->getOrderDetails()->getValues();
        $productsForStripe = [];
        foreach ($products as $item) {
            $productsForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()
                    ]
                ],
                'quantity' => $item->getQuantity()
            ];
        }
        // Ajout des frais de livraison
        $productsForStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName()
                ]
            ],
            'quantity' => 1
        ];
        Stripe::setApiKey('sk_test_51Kb6uhClAQQ2TXfzOspWIks7VFbXX5e5ZTr5c4VCIQfNJATKvQZDHBODlaDkCnNmYntKUQLZK8YF4UbNPA5gMWzg00RHLAzE0G');
        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'https://ecommerce.tristan-bonnal.fr';
        
        // Création de la session Stripe avec les données du panier
        $checkout_session = Session::create([
            'line_items' => $productsForStripe,
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/valide/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/echec/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeSession($checkout_session->id);
        $em->flush();
        return $this->redirect($checkout_session->url);
    }



    /**
     * Méthode appelée lorsque le paiement est validé
     */
    #[Route('/commande/valide/{stripeSession}', name: 'payment_success')]
    public function paymentSuccess(OrderRepository $repository, $stripeSession, EntityManagerInterface $em, Cart $cart) 
    {
        $order = $repository->findOneByStripeSession($stripeSession);
        if (!$order || $order->getUser() != $this->getUser()) {
            throw $this->createNotFoundException('Commande innaccessible');
        }
        if (!$order->getState()) {
            $order->setState(1);
            $em->flush();
        }

        // Envoi mail de Confirmation
        $user = $this->getUser();

        $content = "Bonjour {$user->getFirstname()} nous vous remercions de votre commande";
        (new Mail)->send(
            $user->getEmail(), 
            $user->getFirstname(), 
            "Confirmation de la commande {$order->getReference()}", 
            $content
        );

        // Suppression du panier une fois la commande validée
        $cart->remove();    
        return $this->render('payment/success.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * Commande annullée (clic sur retour dans la fenêtre)
     */
    #[Route('/commande/echec/{stripeSession}', name: 'payment_fail')]
    public function paymentFail(OrderRepository $repository, $stripeSession) 
    {
        $order = $repository->findOneByStripeSession($stripeSession);
        if (!$order || $order->getUser() != $this->getUser()) {
            throw $this->createNotFoundException('Commande innaccessible');
        }

        return $this->render('payment/fail.html.twig', [
            'order' => $order
        ]);
    }
}

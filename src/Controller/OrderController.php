<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Model\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * Récupération du panier, choix de l'adresse et du transporteur
     *
     * @param SessionInterface $session
     * @param Cart $cart
     * @return Response
     */
    #[Route('/commande', name: 'order')]
    public function index(SessionInterface $session, Cart $cart): Response
    {
        $user = $this->getUser();
        $cartProducts = $cart->getDetails();

        // Redirection si panier vide
        if (empty($cartProducts['products'])) {   
            return $this->redirectToRoute('product');
        }
        
        //Redirection si utilisateur n'a pas encore d'adresse
        if (!$user->getAddresses()->getValues()) {      //getValues() Récupère directement les valeurs d'une collection d'objet
            $session->set('order', 1);
            return $this->redirectToRoute('account_address_new');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $user     //Permet de passer l'utilisateur courant dans le tableau d'options du OrderType
        ]); 

        return $this->renderForm('order/index.html.twig', [
            'form' => $form,
            'cart' => $cartProducts,
            'totalPrice' =>$cartProducts['totals']['price']
        ]);
    }

    /**
     * Enregistrement des données "en dur" de la commande contenant adresse, transporteur et produits
     * Les relations ne sont pas directement utilisées pour la persistance des données dans les entités Order et OrderDetails
     * pour éviter des incohérences dans le cas ou des modifications seraient faites sur les autres entités par la suite
     *
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    #[Route('/commande/recap', name: 'order_add', methods: 'POST')]
    public function summary(Cart $cart, Request $request, EntityManagerInterface $em): Response
    {
         //Récupération du panier en session
        $cartProducts = $cart->getDetails();   

        //Vérification qu'un formulaire a bien été envoyé précédemment
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()     
        ]); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->get('addresses')->getData();

            $delivery_string = $address->getFirstname() . ' ' . $address->getLastname();
            $delivery_string .= '<br>' . $address->getPhone();
            $delivery_string .= '<br>' . $address->getCompany() ?? '';
            $delivery_string .= '<br>' . $address->getAddress();
            $delivery_string .= '<br>' . $address->getPostal();
            $delivery_string .= '<br>' . $address->getCity();
            $delivery_string .= '<br>' . $address->getCountry();

            $cartProducts = $cart->getDetails();

            //Création de la commande avec les infos formulaire
            $order = new Order;
            $date = new \DateTime;
            $order
                ->setUser($this->getUser())
                ->setCreatedAt($date)
                ->setCarrierName($form->get('carriers')->getData()->getName())
                ->setCarrierPrice($form->get('carriers')->getData()->getPrice())
                ->setDelivery($delivery_string)
                ->setState(0)
                ->setReference($date->format('YmdHis') . '-' . uniqid())
            ;
            $em->persist($order);

            //Création des lignes de détails pour chacun des produits de la commande
            foreach ($cartProducts['products'] as $item) {
                $orderDetails = new OrderDetails();
                $orderDetails
                    ->setBindedOrder($order)
                    ->setProduct($item['product']->getName())
                    ->setQuantity($item['quantity'])
                    ->setPrice($item['product']->getPrice())
                    ->setTotal($item['product']->getPrice() * $item['quantity'])
                ;
                $em->persist($orderDetails);
            }
            $em->flush();

            // Affichage récap
            return $this->renderForm('order/add.html.twig', [
                'cart' => $cartProducts,
                'totalPrice' =>$cartProducts['totals']['price'],
                'order' => $order
            ]);
        }
        //Si pas de formulaire, page non accessible, et donc redirection vers le panier
        return $this->redirectToRoute('cart');
    }
}

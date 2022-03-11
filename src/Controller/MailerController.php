<?php

namespace App\Controller;

use App\Models\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'mailer')]
    public function index(): Response
    {
        $mail = new Mail();
        $mail->send('bonnal.tristan91@gmail.com', 'Tristan Bonnal', 'Lien mot de passe', 'Voici votre lien');
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}

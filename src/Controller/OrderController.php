<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted; // Add this line

#[Route('/commande')]
class OrderController extends AbstractController
{

   
    #[Route('/ajout', name: 'add_order')]

    public function add(): Response
    {
        $email=$this->getUser()->getUserIdentifier();
        return $this->render('order/index.html.twig', [
            'email' => $email,
        ]);
    }
}
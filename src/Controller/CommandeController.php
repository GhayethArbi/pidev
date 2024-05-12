<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commandes', name: 'commandes_index')]
    public function index(): Response
    {
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/new', name: 'create_commande')]
    public function createOrder(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set additional fields like date, user, and status here
            $commande->setDate(new \DateTime());
            $commande->setUser($this->getUser());
            $commande->setStatut('pending'); // You may want to set a default status

            // Persist the command to the database
            $entityManager->persist($commande);
            $entityManager->flush();

            // Redirect to a success page or wherever needed
            return $this->redirectToRoute('order_success');
        }

        return $this->render('commande/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commande/success', name: 'order_success')]
    public function orderSuccess(): Response
    {
        // Render a success page after placing the order
        return $this->render('commande/success.html.twig');
    }
}

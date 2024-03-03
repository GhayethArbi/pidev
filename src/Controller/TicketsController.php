<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\TicketstRepository;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\TicketsFormType;
use App\Entity\Tickets;
use App\Entity\Event;

class TicketsController extends AbstractController
{
    #[Route('/tickets', name: 'app_tickets')]
    public function index(): Response
    {
        return $this->render('tickets/index.html.twig', [
            'controller_name' => 'TicketsController',
        ]);
    }
    #[Route('/addticket', name: 'addticket')]
    public function addticket(Request $request,SluggerInterface $slugger)
    {
        $Tickets = new Tickets();
        $form = $this->createForm(TicketsFormType::class,$Tickets);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
    // ... image de ticket ...//
    $imageFile = $form->get('image')->getData();
    if ($imageFile) {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $imageFile->move(
                $this->getParameter('brochures_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $Tickets->setimage($newFilename);
    }





            // ... persist the $Tickets variable or any other work
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($Tickets);
            $em->flush();
            $this->addFlash('success', " Ajout avec succès!");
          
        }
        return $this->render("tickets/addticket.html.twig",[
            'formB' => $form->createView(),
            'Tickets' => $Tickets, // Pass the $ticket variable to the view
        ])
        
        
      ;
    }
}

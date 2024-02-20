<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
//use App\Controller\EventFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\EventRepository;
//use App\Controller\EventFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\EventFormType;
use App\Entity\Event;
class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(): Response
    {
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
    #[Route('/addevent', name: 'addevent')]
    public function addevent(Request $request)
    {
        $Event = new Event();
        $form = $this->createForm(EventFormType::class,$Event);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
   

            // ... persist the $product variable or any other work
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($Event);
            $em->flush();
            $this->addFlash('success', " Ajout avec succès!");
          
        }
        return $this->render("event/ajouterevents.html.twig", array('formA' => $form->createView()));
    }
    #[Route('/showevents', name:'showevents' )]
    public function showevents()
    {
        $Event = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('event/listeEvents.html.twig', [
            'Event' => $Event,
           ]);
      
    } 
    #[Route('/deleteEvent/{id}', name:'deleteEvent' )]
    
    
    
    public function delete($id):Response
     {
         $Event = $this->getDoctrine()->getRepository(Event::class)->find($id);
         $em = $this->getDoctrine()->getManager();
         $em->remove($Event);
         $em->flush();
         return $this->redirectToRoute('showevents');
 
        }
     
 

 #[Route('/updateEvent/{id}', name:'updateEvent')]
 public function update(Request $request,$id)
 {
     $Event = $this->getDoctrine()->getRepository(Event::class)->find($id);
     $form = $this->createForm(EventFormType::class, $Event);
     $form->add('Modifier',SubmitType::class);
     $form->handleRequest($request);
     if ($form->isSubmitted()) {
         $em = $this->getDoctrine()->getManager();
      
         $em->flush();
         
       
        // return $this->redirectToRoute('showaEvent');
     }
     return $this->render("event/updateEvent.html.twig",array('formA'=>$form->createView()));
 }
   



}

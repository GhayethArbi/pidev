<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;  
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


use Symfony\Component\OptionsResolver\OptionsResolver;


use App\Repository\EventRepository;

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
    public function addevent(Request $request,SluggerInterface $slugger)
    {
        $Event = new Event();
        $form = $this->createForm(EventFormType::class,$Event);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
   
// ... image  ...//
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
    $Event->setimage($newFilename);
}








            // ... persist the $product variable or any other work
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($Event);
            $em->flush();
            return $this->redirectToRoute('showevents');
            $this->addFlash('success', " Ajout avec succès!");
          
        }
        return $this->render("events/ajouterevents.html.twig", array('formA' => $form->createView()));
    }


    #[Route("/recherche_ajax/{nom}", name:"recherche_ajax")]
    
    public function rechercheAjax(Request $request,EventRepository $sr): JsonResponse
    {
        $requestString = $request->query->get('searchValue');
        $resultats = $sr->findStudentByNsc($requestString);

        return $this->json($resultats);
        
    }
    //map.............. //
    #[Route('/mapE', name:'mapE')]

    public function index2(EntityManagerInterface $entityManager): Response
    {
        $Event = $entityManager
            ->getRepository(Event::class)
            ->findAll();

        return $this->render('events/map.html.twig', [
            'Event' => $Event,
        ]);
    }
   //fin map................//


    #[Route('/showevents', name:'showevents' )]
    public function showevents()
    {
        $Event = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('events/listeEvents.html.twig', [
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
     return $this->render("events/updateEvent.html.twig",array('formA'=>$form->createView()));
 }
 #[Route("/statsEvent", name:"statsEvent")] 
 public function statistiquess(EventRepository $evRepo)
    {
        // On va chercher le nombre d'annonces publiées par date
        $evenement = $evRepo->countByDate();

        $dates = [];
        $evenementCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($evenement as $evenements) {
            $dates[] = $evenements['dateevent'];
            $evenementCount[] = $evenements['count'];
        }

        return $this->render('event/statE.html.twig', [

            'dates' => json_encode($dates),
            'evenementCount' => json_encode($evenementCount),
        ]);
    }

   #[Route("/pdfe", name:"pdfe", methods:["GET"])]
   
     
    public function pdf(EventRepository  $rep) :Response
    {


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $Event = $this->getDoctrine()->getRepository(Event::class)->findAll();


        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('events/pdfE.html.twig',[
            'Event' => $Event,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("EventList.pdf", [
            "Attachment" => true
        ]);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");

    }








}

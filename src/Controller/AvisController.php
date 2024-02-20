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
use App\Form\FeedBackFormType;
use App\Entity\FeedBack;
use App\Entity\Users;
class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(): Response
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    #[Route('/addavis', name: 'addavis')]
    public function addavis(Request $request)
    {
        $FeedBack = new FeedBack();
        $form = $this->createForm(FeedBackFormType::class,$FeedBack);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
   

            // ... persist the $product variable or any other work
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($FeedBack);
            $em->flush();
           
          
        }
        return $this->render("avis/addFeedBack.html.twig", array('formC' => $form->createView()));
    }
    #[Route('/showAvis', name:'showAvis' )]
    public function showAvis()
    {
        $FeedBack = $this->getDoctrine()->getRepository(FeedBack::class)->findAll();
        return $this->render('avis/listsA.html.twig', [
            'FeedBack' => $FeedBack,
           ]);
      
    } 
}

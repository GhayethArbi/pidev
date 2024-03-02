<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventFormType;
use App\Entity\Event;
use App\Repository\EventRepository;

use App\Form\FeedbackFormType;
use App\Entity\FeedBack;
use App\Repository\FeedBackRepository;

class FrontxController extends AbstractController
{
    #[Route('/frontx', name: '/frontx')]
    public function indexEvent(): Response
    {
        $Event = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('frontx/index.html.twig', [
            'Event' => $Event,
        ]);
    }


    #[Route('/frontAvis', name: '/frontAvis')]
    public function indexAvis(): Response
    {
        $FeedBack = $this->getDoctrine()->getRepository(FeedBack::class)->findAll();
        return $this->render('frontx/indexfeed.html.twig', [
            'FeedBack' => $FeedBack,
        ]);
    }





}


<?php

namespace App\Controller;


use App\Repository\ObjectifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/interface', name: 'app_user_interface')]
class UserInterfaceController extends AbstractController
{
    #[Route('/', name: 'app_user_interface_base_user', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user_interface/base_user.html.twig', [
            'controller_name' => 'UserInterfaceController',
        ]);
    }
    #[Route('/activities', name: 'app_user_interface_activities', methods: ['GET'])]
    public function display_pics(ObjectifRepository $objectifRepository): Response
    {
        return $this->render('user_interface/activities.html.twig', [
            'activities' => $objectifRepository->findAll(),
        ]);
    }
}

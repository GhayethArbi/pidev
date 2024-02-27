<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('UserTpl/baseU.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/objectifs', name: 'app_user_objectifs')]
    public function lister_objectifs(): Response{
        return $this->render('UserTpl/objectifs.html.twig') ;
    } 
}

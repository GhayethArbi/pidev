<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecceteUserController extends AbstractController
{
    #[Route('/reccete/user', name: 'app_reccete_user')]
    public function index(): Response
    {
        return $this->render('reccete_user/index.html.twig', [
            'controller_name' => 'RecceteUserController',
        ]);
    }

    #[Route('/recette_user', name: 'app_user_reccette_plan', methods: ['GET'])]
    public function display_pics(RecetteRepository $RecetteRepository): Response
    {
        return $this->render('reccete_user/index.html.twig', [
            'recette' => $RecetteRepository->findAll(),
        ]);
    }
}

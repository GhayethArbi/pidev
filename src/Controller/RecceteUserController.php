<?php

namespace App\Controller;


use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecceteUserController extends AbstractController
{
    #[Route('/recette/user', name: 'app_reccete_user')]
    public function index(): Response
    {
        return $this->render('reccete_user/index.html.twig', [
            'recettes' => 'RecceteUserController',
        ]);
    }

    #[Route('/recette_user', name: 'app_user_reccette_plan', methods: ['GET'])]
    public function display_pics(RecetteRepository $RecetteRepository): Response
    {
        return $this->render('reccete_user/index.html.twig', [
            'recettes' => $RecetteRepository->findAll(),
        ]);
    }
    #[Route('/{id}/recette_user', name: 'app_user_recette_show', methods: ['GET'])]
    public function show_recette(Recette $recette): Response
    {
        return $this->render('reccete_user\recette_details.html.twig', [
            'recette' => $recette,
        ]);
    }
}

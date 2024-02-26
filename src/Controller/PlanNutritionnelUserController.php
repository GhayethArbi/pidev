<?php

namespace App\Controller;
use App\Entity\PlanNutritionnel;
use App\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlanNutritionnelType;
use App\Repository\PlanNutritionnelRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlanNutritionnelUserController extends AbstractController
{
    #[Route('/plan/user', name: 'app_plan_nutritionnel_user')]
    public function index(): Response
    {
           return $this->render('plan_nutritionnel_user/index.html.twig', [
            'controller_name' => 'PlanNutritionnelUserController',
        ]);
    }
    #[Route('/plan_user', name: 'app_user_interface_plan', methods: ['GET'])]
    public function display_pics(PlanNutritionnelRepository $PlanNutritionnel): Response
    {
        return $this->render('plan_nutritionnel_user/show.html.twig', [
            'plan_nutritionnel' => $PlanNutritionnel->findAll(),
        ]);
    }
}

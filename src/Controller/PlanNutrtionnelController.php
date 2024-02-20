<?php

namespace App\Controller;

use App\Entity\PlanNutritionnel;
use App\Form\PlanNutritionnelType;
use App\Repository\PlanNutritionnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanNutrtionnelController extends AbstractController
{
    #[Route('/plan', name: 'app_plan_nutrtionnel_index', methods: ['GET'])]
    public function index(PlanNutritionnelRepository $planNutritionnelRepository): Response
    {
        return $this->render('plan_nutrtionnel/index.html.twig', [
            'plan_nutritionnels' => $planNutritionnelRepository->findAll(),
        ]);
    } 
    #[Route('/plan_user', name: 'app_plan_nutrtionnel_index', methods: ['GET'])]
    public function index_user(PlanNutritionnelRepository $planNutritionnelRepository): Response
    {
        return $this->render('/user/plan_nutrtionnel/index.html.twig', [
            'plan_nutritionnels' => $planNutritionnelRepository->findAll(),
        ]);
    }

    #[Route('/new_planN', name: 'app_plan_nutrtionnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planNutritionnel = new PlanNutritionnel();
        $form = $this->createForm(PlanNutritionnelType::class, $planNutritionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la recette associée à partir du formulaire
        $recette = $form->get('recette')->getData();


            $entityManager->persist($planNutritionnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_nutrtionnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_nutrtionnel/new.html.twig', [
            'plan_nutritionnel' => $planNutritionnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_nutrtionnel_show', methods: ['GET'])]
    public function show(PlanNutritionnel $planNutritionnel): Response
    {
        return $this->render('plan_nutrtionnel/show.html.twig', [
            'plan_nutritionnel' => $planNutritionnel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plan_nutrtionnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanNutritionnel $planNutritionnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanNutritionnelType::class, $planNutritionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_nutrtionnel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_nutrtionnel/edit.html.twig', [
            'plan_nutritionnel' => $planNutritionnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_nutrtionnel_delete', methods: ['POST'])]
    public function delete(Request $request, PlanNutritionnel $planNutritionnel, EntityManagerInterface $entityManager): Response
    {
       
        if ($this->isCsrfTokenValid('delete'.$planNutritionnel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($planNutritionnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_plan_nutrtionnel_index', [], Response::HTTP_SEE_OTHER);
    }
}

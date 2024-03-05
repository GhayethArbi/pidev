<?php

namespace App\Controller;
use App\Entity\PlanNutritionnel;
use App\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PlanNutritionnelType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PlanNutritionnelRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlanNutritionnelUserController extends AbstractController
{

    #[Route('/plan/user', name: 'app_user_interface_plan', methods: ['GET'])]
    public function index(PlanNutritionnelRepository $PlanNutritionnel): Response
    {
        return $this->render('plan_nutritionnel_user/index.html.twig', [
            'plan_nutritionnels' => $PlanNutritionnel->findAll(),
        ]);
    }

    #[Route('/new/plan/user', name: 'app_user_plan_nutrtionnel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planNutritionnel = new PlanNutritionnel();
        $form = $this->createForm(PlanNutritionnelType::class, $planNutritionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planNutritionnel);
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_nutritionnel_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_nutritionnel_user/new.html.twig', [
            'plan_nutritionnel' => $planNutritionnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit_user_plan', name: 'app_user_plan_nutrtionnel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanNutritionnel $planNutritionnel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanNutritionnelType::class, $planNutritionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_nutritionnel_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plan_nutritionnel_user/edit.html.twig', [
            'plan_nutritionnel' => $planNutritionnel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete_plan_user', name: 'app_user_plan_nutrtionnel_delete', methods: ['POST'])]
    public function delete(Request $request, PlanNutritionnel $planNutritionnel, EntityManagerInterface $entityManager): Response
    {
       
        if ($this->isCsrfTokenValid('delete'.$planNutritionnel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($planNutritionnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_plan_nutritionnel_user', [], Response::HTTP_SEE_OTHER);
    }
  
}

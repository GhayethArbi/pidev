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

class NameController extends AbstractController
{
    #[Route('/recette_admin', name: 'app_name_index', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository, EntityManagerInterface $entityManager): Response
    {
        $Breakfastcount = $entityManager->getRepository(Recette::class)->count(['category' => 'Breakfast']);
        $Lunchcount = $entityManager->getRepository(Recette::class)->count(['category' => 'Lunch']);
            
        return $this->render('admin/index.html.twig', [
            'recettes' => $recetteRepository->findAll(),
            'Breakfastcount' => $Breakfastcount,
            'Lunchcount' => $Lunchcount,
        ]);
    }

    #[Route('/new_recette_admin', name: 'app_name_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recette = new Recette();
        // Set the current date and time
        $recette->setDate(new \DateTime());

        $form = $this->createForm(RecetteType::class, $recette, 
        [ 'exclude_date_field' => true
        ]);
        //form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/recette_admin', name: 'app_name_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('admin/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/{id}/edit_recette_admin', name: 'app_name_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecetteType::class, $recette,
        [ 'exclude_date_field' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete_recette', name: 'app_name_delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_name_index', [], Response::HTTP_SEE_OTHER);
    }
}

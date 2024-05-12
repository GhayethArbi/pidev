<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecceteUserController extends AbstractController
{
    #[Route('/{id}/delete_recette_user', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_reccette_plan', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}/edit_recette_user', name: 'app_recette_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecetteType::class, $recette,
        [ 'exclude_date_field' => true
    ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_reccette_plan', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reccete_user/edit_recipe_user.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/recette/user', name: 'app_reccete_user')]
    public function index(): Response
    {
        return $this->render('reccete_user/index.html.twig', [
            'recettes' => 'RecceteUserController',
        ]);
    }

    #[Route('/recette_user', name: 'app_user_reccette_plan', methods: ['GET'])]
public function display_pics(RecetteRepository $recetteRepository, Request $request, PaginatorInterface $paginator): Response
{ 
    // Retrieve all recipes from the repository
    $allRecettes = $recetteRepository->findAll();

    // Paginate the results
    $recettes = $paginator->paginate(
        $allRecettes, // Pass the query (not the result)
        $request->query->getInt('page', 1), // Get the current page from the request
        8 // Number of items per page
    );

    return $this->render('reccete_user/index.html.twig', [
        'recettes' => $recettes, // Pass paginated recipes to the template
    ]);
}

    

    #[Route('/{id}/recette_user', name: 'app_user_recette_show', methods: ['GET'])]
    public function show_recette(Recette $recette): Response
    {
       
        return $this->render('reccete_user\recette_details.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/new_recette_user', name: 'app_recipes_new', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_user_reccette_plan', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reccete_user/add_new_recipes.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }
}

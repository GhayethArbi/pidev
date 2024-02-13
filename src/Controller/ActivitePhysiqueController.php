<?php

namespace App\Controller;

use App\Entity\ActivitePhysique;
use App\Form\ActivitePhysiqueType;
use App\Repository\ActivitePhysiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activite/physique')]
class ActivitePhysiqueController extends AbstractController
{
    #[Route('/', name: 'app_activite_physique_index', methods: ['GET'])]
    public function index(ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        return $this->render('activite_physique/index.html.twig', [
            'activite_physiques' => $activitePhysiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activite_physique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activitePhysique = new ActivitePhysique();
        $form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activitePhysique);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_physique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite_physique/new.html.twig', [
            'activite_physique' => $activitePhysique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activite_physique_show', methods: ['GET'])]
    public function show(ActivitePhysique $activitePhysique): Response
    {
        return $this->render('activite_physique/show.html.twig', [
            'activite_physique' => $activitePhysique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activite_physique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActivitePhysique $activitePhysique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_physique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite_physique/edit.html.twig', [
            'activite_physique' => $activitePhysique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_activite_physique_delete', methods: ['POST'])]
    public function delete(Request $request, ActivitePhysique $activitePhysique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activitePhysique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activitePhysique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_physique_index', [], Response::HTTP_SEE_OTHER);
    }
}

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
            $file = $form->get('Image_Activite')->getData();
        if ($file) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            $activitePhysique->setImageActivite($fileName);        }
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
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $activitePhysique = $entityManager->getRepository(ActivitePhysique::class)->find($id);

        if (!$activitePhysique) {
            throw $this->createNotFoundException('ActivitePhysique not found');
        }

        return $this->render('activite_physique/show.html.twig', [
            'activite_physique' => $activitePhysique,
        ]);
    }
    /*public function show(ActivitePhysique $activitePhysique): Response
    {
        return $this->render('activite_physique/show.html.twig', [
            'activite_physique' => $activitePhysique,
        ]);
    }*/

    #[Route('/{id}/edit', name: 'app_activite_physique_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'entité ActivitePhysique en utilisant son identifiant
        $activitePhysique = $entityManager->getRepository(ActivitePhysique::class)->find($id);

        // Vérifier si l'entité a été trouvée
        if (!$activitePhysique) {
            throw $this->createNotFoundException('ActivitePhysique not found');
        }

        // Créer le formulaire
        $form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
        $form->handleRequest($request);

        // Traiter le formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
             $file = $form->get('Image_Activite')->getData();
        if ($file) {
            // Supprimer l'ancienne image si nécessaire
            $oldFileName = $activitePhysique->getImageActivite();
            if ($oldFileName) {
                $oldFilePath = $this->getParameter('uploads_directory') . '/' . $oldFileName;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            // Générer un nouveau nom de fichier unique pour l'image
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Déplacer le fichier téléchargé vers le répertoire spécifié
            $file->move(
                $this->getParameter('uploads_directory'),
                $fileName
            );
            // Définir le nom du fichier dans l'entité ActivitePhysique
            $activitePhysique->setImageActivite($fileName);
        }
            // Persister les changements dans la base de données
            $entityManager->flush();

            // Rediriger vers la page d'index des activités physiques
            return $this->redirectToRoute('app_activite_physique_index');
        }

        // Rendre le template avec le formulaire et l'entité
        return $this->render('activite_physique/edit.html.twig', [
            'activite_physique' => $activitePhysique,
            'form' => $form->createView(),
        ]);
    }
    /*#[Route('/{id}/edit', name: 'app_activite_physique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ActivitePhysique $activitePhysique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_physique_index');
        }

        return $this->render('activite_physique/edit.html.twig', [
            'activite_physique' => $activitePhysique,
            'form' => $form->createView(),
        ]);
    }*/

    #[Route('/{id}/delete', name: 'app_activite_physique_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager, ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        $activitePhysique = $activitePhysiqueRepository->find($id);
    
        if (!$activitePhysique) {
            throw $this->createNotFoundException('Activité physique non trouvée.');
        }
        
            $entityManager->remove($activitePhysique);
            $entityManager->flush();
            $this->addFlash('success', 'L\'activité physique a été supprimée avec succès.');
        return $this->redirectToRoute('app_activite_physique_index');
    }
}

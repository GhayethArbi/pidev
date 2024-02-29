<?php

namespace App\Controller;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use App\Form\ActivitePhysiqueType;
use App\Repository\ActivitePhysiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


#[Route('/activite/physique')]
class ActivitePhysiqueController extends AbstractController
{
    #[Route('/', name: 'app_activite_physique_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        $musculationCount = $entityManager->getRepository(ActivitePhysique::class)->count(['Type_Activite' => 'musculation']);
        $cardioCount = $entityManager->getRepository(ActivitePhysique::class)->count(['Type_Activite' => 'cardiovasculaire']);
        return $this->render('activite_physique/index.html.twig', [
            'musculationCount' => $musculationCount,
            'cardioCount' => $cardioCount,
            'activite_physiques' => $activitePhysiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activite_physique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activitePhysique = new ActivitePhysique();
        $form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
        $form
        ->add('Nom_Activite') 
        ->add('Type_Activite', ChoiceType::class, [
            'choices' => [
                'Cardiovasculaire' => 'cardiovasculaire',
                'Musculation' => 'musculation',
            ]])
            ->add('Image_Activite', FileType::class, [
                'mapped' => false,
                'label' => 'Image activité',
                'required' => False,
            ])
            ->add('objectifs', EntityType::class, [
                'class' => Objectif::class,
                'choice_label' => function ($objectif) {
                    return $objectif->getId() . ' - ' . $objectif->getNomObjectif(); // Modify this according to your Objectif entity properties
                }, // Assuming "nom" is the property to display for objectives
                'multiple' => true,
                'expanded' => true, // Render checkboxes instead of a select input
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['Image_Activite']->getData();

    if ($uploadedFile) {
        // Logique de gestion du fichier ici
        $uploadsDirectory = $this->getParameter('uploads_directory');
        $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move(
            $uploadsDirectory,
            $filename
        );

        // Assurez-vous que le nom du fichier est correctement défini dans l'entité
        $activitePhysique->setImageActivite($filename);}
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
    public function edit(int $id,Request $request, ActivitePhysique $activitePhysique, EntityManagerInterface $entityManager): Response
    {
// Récupérer l'entité ActivitePhysique en utilisant son identifiant
$activitePhysique = $entityManager->getRepository(ActivitePhysique::class)->find($id);

// Vérifier si l'entité a été trouvée
if (!$activitePhysique) {
    throw $this->createNotFoundException('ActivitePhysique not found');
}

// Créer le formulaire
$form = $this->createForm(ActivitePhysiqueType::class, $activitePhysique);
$form->add('Nom_Activite') 
->add('Type_Activite', ChoiceType::class, [
    'choices' => [
        'Cardiovasculaire' => 'cardiovasculaire',
        'Musculation' => 'musculation',
    ]])
    ->add('Image_Activite', FileType::class, [
        'mapped' => false,
        'label' => 'Image activité',
        'required' => False,
    ])
    ->add('objectifs', EntityType::class, [
        'class' => Objectif::class,
        'choice_label' => function ($objectif) {
            return $objectif->getId() . ' - ' . $objectif->getNomObjectif(); // Modify this according to your Objectif entity properties
        }, // Assuming "nom" is the property to display for objectives
        'multiple' => true,
        'expanded' => true, // Render checkboxes instead of a select input
    ]);
$form->handleRequest($request);

// Traiter le formulaire soumis
if ($form->isSubmitted() && $form->isValid()) {
      // Handle file upload for edit action
      $uploadedFile = $form['Image_Activite']->getData(); // Corrected to match your form field name

      if ($uploadedFile) { // Check if a new file was uploaded
          $uploadsDirectory = $this->getParameter('uploads_directory');
          $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
          $uploadedFile->move(
              $uploadsDirectory,
              $filename
          );

          // Set the new filename to your entity
          $activitePhysique->setImageActivite($filename); 
      }
      // Persist the product entity regardless of whether a file was uploaded or not
        $entityManager->flush();

            return $this->redirectToRoute('app_activite_physique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite_physique/edit.html.twig', [
            'activite_physique' => $activitePhysique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activite_physique_delete', methods: ['POST'])]
    public function delete(Request $request, ActivitePhysique $activitePhysique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activitePhysique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activitePhysique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_physique_index', [], Response::HTTP_SEE_OTHER);
    }
}

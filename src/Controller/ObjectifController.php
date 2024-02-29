<?php

namespace App\Controller;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use App\Form\ObjectifType;
use App\Repository\ObjectifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objectif')]
class ObjectifController extends AbstractController
{
    #[Route('/', name: 'app_objectif_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager,ObjectifRepository $objectifRepository): Response
    {
        $PertePoidsCount = $entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'perte de poids']);
        $RenforcementMCount = $entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'renforcement musculaire']);
        $AmeliorationECount=$entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'amelioration endurance']);
        $ReductionSCount=$entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'reduction du stress']);
        $AugmentationmMCount=$entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'augmentation de la masse musculaire']);
        $MaintienFPCount=$entityManager->getRepository(Objectif::class)->count(['Nom_Objectif' => 'maintien de la forme physique']);
        return $this->render('objectif/index.html.twig', [
            'objectifs' => $objectifRepository->findAll(), 
            'pertePoidsCount'=>$PertePoidsCount,
            'RenforcementCount' =>$RenforcementMCount,
            'AmeliorationECount'=>$AmeliorationECount,
            'ReductionSCount'=>$ReductionSCount,
            'AugmentationMCount'=>$AugmentationmMCount,
            'MaintienFPCount'=>$MaintienFPCount,
        ]);
    }

    #[Route('/new', name: 'app_objectif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->add('Nom_Objectif', ChoiceType::class, [
            'choices' => [
                'Perte de poids' => 'perte de poids',
                'Renforcement musculaire' => 'renforcement musculaire',
                'Amélioration endurance'=>'amelioration endurance',
                'Réduction du stress'=>'reduction du stress',
                'Augmentation de la masse musculaire'=>'augmentation de la masse musculaire',
                "Maintien de la forme physique"=>"maintien de la forme physique",
            ]])->add('Total_Calories')
        ->add('Total_Duree')
        ->add('Note')
        ->add('Activites', EntityType::class, [
            'class' => ActivitePhysique::class,
            'choice_label' => function ($activite) {
                return $activite->getId() . ' - ' . $activite->getNomActivite(); // Modify this according to your Objectif entity properties
            }, // Assuming "nom" is the property to display for objectives/ Assuming "nom" is the property to display for objectives
            'multiple' => true,
            'expanded' => true, // Render checkboxes instead of a select input
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($objectif);
            $entityManager->flush();

            return $this->redirectToRoute('app_objectif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objectif/new.html.twig', [
            'objectif' => $objectif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectif_show', methods: ['GET'])]
    public function show(Objectif $objectif): Response
    {
        return $this->render('objectif/show.html.twig', [
            'objectif' => $objectif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objectif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objectif $objectif, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->add('Nom_Objectif', ChoiceType::class, [
            'choices' => [
                'Perte de poids' => 'perte de poids',
                'Renforcement musculaire' => 'renforcement musculaire',
                'Amélioration endurance'=>'amelioration endurance',
                'Réduction du stress'=>'reduction du stress',
                'Augmentation de la masse musculaire'=>'augmentation de la masse musculaire',
                "Maintien de la forme physique"=>"maintien de la forme physique",
            ]])->add('Total_Calories')
        ->add('Total_Duree')
        ->add('Note')
        ->add('Activites', EntityType::class, [
            'class' => ActivitePhysique::class,
            'choice_label' => function ($activite) {
                return $activite->getId() . ' - ' . $activite->getNomActivite(); // Modify this according to your Objectif entity properties
            }, // Assuming "nom" is the property to display for objectives/ Assuming "nom" is the property to display for objectives
            'multiple' => true,
            'expanded' => true, // Render checkboxes instead of a select input
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_objectif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objectif/edit.html.twig', [
            'objectif' => $objectif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objectif_delete', methods: ['POST'])]
    public function delete(Request $request, Objectif $objectif, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objectif->getId(), $request->request->get('_token'))) {
            $entityManager->remove($objectif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_objectif_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use App\Form\ActivitePhysiqueType;
use App\Form\ObjectifType;
use App\Repository\ActivitePhysiqueRepository;
use App\Repository\ObjectifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('UserTpl/baseU.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/objectifs', name: 'app_user_objectifs')]
    public function lister_objectifs(): Response
    {
        return $this->render('UserTpl/objectifs.html.twig');
    }

    #[Route('/objectifs/create_Obj/{data}', name: 'app_user_créer_objectif')]
    public function createObjectif(string $data, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);
        $objectif->setNomObjectif($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($objectif);
            $entityManagerInterface->flush();
            $idObjectif = $objectif->getId();
            // dd($objectif);
            return $this->redirectToRoute('app_user_select_activites', ['idObj' => $idObjectif, 'data' => $data]);
        }

        return $this->renderForm(
            'UserTpl/newObjectif.html.twig',
            [
                'objectif' => $objectif,
                'form' => $form,
            ]
        );
    }

    #[Route('/objectifs/create_Obj/{data}/select_activites/{idObj}', name: 'app_user_select_activites')]
    public function selectActivites(string $data, int $idObj, ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        $activites = $activitePhysiqueRepository->findActivitiesWithUniqueNames();
        return $this->render('UserTpl/activites.html.twig', [
            'activites' => $activites,
            'data' => $data,
            'idObj' => $idObj,
        ],);
    }

   /* #[Route('objectifs/create_Obj/{data}/select_activites/{idObj}/createActivite/{nomAct}', name: 'app_user_create_activite')]
    public function createActivite(string $data, int $idObj, Request $request, string $nomAct, ObjectifRepository $objectifRepository, EntityManagerInterface $entityManagerInterface, ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        $actualactivites  = $objectifRepository->listActivitesbyIdObj($idObj);
        dd($actualactivites);   
        $actualobjectif = $objectifRepository->find($idObj);
        $newactivite = new ActivitePhysique();
        $form = $this->createForm(ActivitePhysiqueType::class, $newactivite);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           // $newactivite->setNomActivite($actualactivite->getNomActivite());
            //$newactivite->setTypeActivite($actualactivite->getTypeActivite());
            //$newactivite->setImageActivite($actualactivite->getImageActivite());
           // $newactivite->addObjectif($actualobjectif);
            dd($newactivite);
            $entityManagerInterface->persist($newactivite);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_user_select_activites', ['idObj' => $idObj, 'data' => $data]);
        }
        return $this->renderForm('userTpl/formActivite.html.twig', [
            'form' => $form,
            'activite' => $newactivite,
        ]);
    }*/
    #[Route('objectifs/create_Obj/{data}/select_activites/{idObj}/createActivite/{nomAct}', name: 'app_user_create_activite')]
    public function createActivite(string $data, int $idObj, Request $request, string $nomAct, ObjectifRepository $objectifRepository, EntityManagerInterface $entityManagerInterface, ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {  
        $actualactivite  = $activitePhysiqueRepository->findOneBy(['Nom_Activite' => $nomAct]);
        $actualobjectif = $objectifRepository->find($idObj);
        $newactivite = new ActivitePhysique();
        $form = $this->createForm(ActivitePhysiqueType::class, $newactivite);
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
            ]) ;
        $form->handleRequest($request);
        $newactivite->setNomActivite($actualactivite->getNomActivite());
        $newactivite->setTypeActivite($actualactivite->getTypeActivite());
        $newactivite->setImageActivite($actualactivite->getImageActivite());
        $newactivite->addObjectif($actualobjectif);
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
               $newactivite->setImageActivite($filename);}
               $entityManagerInterface->persist($newactivite);
               $entityManagerInterface->flush();
               return $this->redirectToRoute('app_user_select_activites', ['idObj' => $idObj, 'data' => $data]);
        }
        return $this->renderForm('userTpl/formActivite.html.twig', [
            'form' => $form,
            'activite' => $newactivite,
        ]);
    }
}

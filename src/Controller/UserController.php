<?php

namespace App\Controller;

use App\Entity\ActivitePhysique;
use App\Entity\Objectif;
use App\Form\ActivitePhysiqueType;
use App\Form\ChangePasswordType;
use App\Form\ObjectifType;
use App\Form\ProfileFormType;
use App\Repository\ActivitePhysiqueRepository;
use App\Repository\ObjectifRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function indexx(): Response
    {
        return $this->render('Client/index.html.twig');
    }

    #[Route('/user/Profile', name: 'user')]
    public function editUserProfile(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //*********change details************
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->add('submit', SubmitType::class, [
            'label' => 'Save Changes',
            'attr' => ['class' => 'btn btn-primary']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('user');
        }



        //******change password *********

        $formPassword = $this->createForm(ChangePasswordType::class);
        //can make button here...
        $formPassword->add('submit', SubmitType::class, [
            'label' => 'Change Password',
            'attr' => ['class' => 'btn btn-primary']
        ]);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {

            $formData = $formPassword->getData();

            if (!$passwordEncoder->isPasswordValid($user, $formData['currentPassword'])) {
                $formPassword->get('currentPassword')->addError(new \Symfony\Component\Form\FormError('Incorrect current password'));
                $this->addFlash(
                    'notice', // Change 'notice' to 'danger'
                    'Your changes were not saved. Please check your current password and try again.'
                );
                return $this->redirectToRoute('user');
            } else {
                $encodedPassword = $passwordEncoder->encodePassword($user, $formData['password']);
                $userRepository->changePassword($user, $encodedPassword);
                // Update the user's password using the password upgrader
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Your password were saved!'
                );
                return $this->redirectToRoute('user');
            }
        }

        return $this->render('user/profile.html.twig', [
            'form' => $form->createView(), 'formPassword' => $formPassword->createView(), 'user' => $user,
        ]);
    }

   
    #[Route('/access-denied/error404', name: 'app_access')]
    public function accessDenied(): Response
    {
        return $this->render('Client/access.html.twig');
    }
    
    //////////////////////////////////sofien
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
                ]
            ])
            ->add('Image_Activite', FileType::class, [
                'mapped' => false,
                'label' => 'Image activité',
                'required' => False,
            ]);
        $form->handleRequest($request);
        $newactivite->setNomActivite($actualactivite->getNomActivite());
        $newactivite->setTypeActivite($actualactivite->getTypeActivite());
        $newactivite->setImageActivite($actualactivite->getImageActivite());
        $newactivite->addObjectif($actualobjectif);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['Image_Activite']->getData();
            $actualobjectif->addActivite($newactivite);
            $actualobjectif->setTotalDuree($actualobjectif->getTotalDuree() + $newactivite->getDureeActivite());
            $actualobjectif->setTotalCalories($actualobjectif->getTotalCalories() + $newactivite->getCaloriesBrules());
            if ($uploadedFile) {
                // Logique de gestion du fichier ici
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $uploadsDirectory,
                    $filename
                );
                // Assurez-vous que le nom du fichier est correctement défini dans l'entité
                $newactivite->setImageActivite($filename);
            }
            $entityManagerInterface->persist($newactivite);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_user_select_activites', ['idObj' => $idObj, 'data' => $data]);
        }
        return $this->renderForm('userTpl/formActivite.html.twig', [
            'form' => $form,
            'activite' => $newactivite,
        ]);
    }

    #[Route('/created_objectives', name: 'app_user_created_objectives')]
    public function objectifs_crees(ObjectifRepository $objectifRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->addFlash(
            'notice', // Change 'notice' to 'danger'
            'The empty Objective will be automatically removed!'
        );
        $objectifs = $objectifRepository->findAll();
        foreach ($objectifs as $objectif) {
            if ($objectif->getActivites()->isEmpty()) {
                $entityManagerInterface->remove($objectif);
                $entityManagerInterface->flush();
            }
        }
        $objectifcrees = $objectifRepository->findAll();
        return $this->render('UserTpl/objectifscrees.html.twig', [
            'objectifscrees' =>  $objectifcrees
        ]);
    }
    #[Route('user/created_objectives/associated_activities/{idObj}', name: 'app_user_associated_activities')]
    public function activites_associes(
        int $idObj,
        ObjectifRepository $objectifRepository,
        EntityManagerInterface $entityManagerInterface
    ): Response {
        $objectif = $objectifRepository->find($idObj);
        $activite_associes = $objectif->getActivites();
        //dd($activite_associes->getValues())  ;    
        return $this->render('UserTpl/activitesassocies.html.twig', [
            'activitesassocies' => $activite_associes,
            'idObj' => $idObj
        ]);
    }
    #[Route('user/created_objectives/associated_activities/{idObj}/RemoveActivite{idAct}', name: 'app_user_remove-associated-activite')]
    public function remove_activites_associes(int $idObj, EntityManagerInterface $entityManagerInterface, int $idAct, ObjectifRepository $objectifRepository, ActivitePhysiqueRepository $activitePhysiqueRepository): Response
    {
        //dd($idObj) ;
        $actualactivite = $activitePhysiqueRepository->find($idAct);
        $actualobjectif = $objectifRepository->find($idObj);
        $actualobjectif->removeActivite($actualactivite);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_user_associated_activities', ['idObj' => $idObj]);
    }

    #[Route('/full/calendar', name: 'app_full_calendar')]
    public function full_calendar(ObjectifRepository $objectifRepository): Response
    {
        $objectifs = $objectifRepository->findAll();
        #dd($objectifs) ; 
        $objectifArray = [];

        foreach ($objectifs as $objectif) {
            $objectifArray[] = [
                'id' => $objectif->getId(),
                'title' => $objectif->getNomObjectif(),
                'start' => $objectif->getDateObjectif()->format('Y-m-d H:i:s'), // Notez le 'Y' pour l'année en majuscule
                'description' => $objectif->getNote(),
            ];
        }

        $data = json_encode($objectifArray);
        return $this->render('UserTpl/full_calendar.html.twig', compact('data'));
    }
    #[Route('/full/calendar/{id}/edit/', name: 'app_full_calendar_edit', methods: ['PUT'])]
    public function full_calendar_edit(
        int $id,
        Objectif $objectif,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        ObjectifRepository $objectifRepository
    ): Response {
        $donnees = json_decode($request->getContent());
        dd($donnees);
        if (
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description)
        ) {
            //on initialise un code
            //les donnés sont complètes 
            $code = 200;
            $objectif = $objectifRepository->find($id);
            //on vérifie si l'id existe 
            if ($objectif == null) {
                //on initialise un objectif
                $objectif = new Objectif();
                //on change le code 
                $code = 201;
            }
            $objectif->setNomObjectif($donnees->title);
            $objectif->setDateObjectif(new DateTime($donnees->start));
            $objectif->setNote($donnees->description);
            $entityManagerInterface->flush();
            // on retourne le code 

            return new Response("ok", $code);
        } else {
            return new Response('Données incomplètes', 400);
        }
    }
}

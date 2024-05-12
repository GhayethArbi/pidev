<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\LoyalityPointsType;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController

{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/users', name: 'app_users')]
    public function usersList(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('admin/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/dashboard', name: 'app_dashbord')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.roles LIKE :role')
            ->andWhere('u.registrationDate >= :registrationDate')
            ->setParameter('role', '%"ROLE_USER"%')
            ->setParameter('registrationDate', new \DateTime('-1 year'))
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/dashbord.html.twig', [
            'userCount' => $users,
        ]);
    }

    #[Route('/adminProfile', name: 'app_profile_admin')]
    public function editAdminProfile(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //*********change details************
        $userEmail = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository->findOneBy(['email' => $userEmail]);
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->add('submit', SubmitType::class, [
            'label' => 'Save Changes',
            'attr' => ['class' => 'btn btn-primary']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['profileImage']->getData();
            if ($uploadedFile) {
                // Logique de gestion du fichier ici
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $uploadsDirectory,
                    $filename
                );

                // Assurez-vous que le nom du fichier est correctement défini dans l'entité
                $user->setProfileImage($filename);
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('app_profile_admin');
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
                return $this->redirectToRoute('app_profile_admin');
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
                return $this->redirectToRoute('app_profile_admin');
            }
        }

        return $this->render('admin/profile.html.twig', [
            'form' => $form->createView(), 'formPassword' => $formPassword->createView(), 'user' => $user,
        ]);
    }



    //**********Edit User*************
    #[Route('/edit/{id}', name: 'app_user_edit')]
    public function edit(UserRepository $repo, Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $repo->find($id);
        $form = $this->createForm(LoyalityPointsType::class, $user);
        $form->add('submit', SubmitType::class, [
            'label' => 'Save Changes',
            'attr' => ['class' => 'btn btn-primary']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', "Loyality points has changed with success!");
            return $this->redirectToRoute('app_users');
        }
        return $this->render('admin/editUser.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);
    }


    //*********delete************/
    #[Route('/delete/{id}', name: 'app_user_delete')]
    public function delete(UserRepository $repo, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $repo->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('notice', "User is deleted!");
        return $this->redirectToRoute('app_users');
    }

    //*********ban user************/
    #[Route('/banning/{id}', name: 'app_user_isBanned')]
    public function banne(UserRepository $repo, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $repo->find($id);
        if ($user->getIsBanned() == true) {
            $user->setIsBanned(false);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', "User is allowed!");
        } else {
            $user->setIsBanned(true);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', "User is banned!");
        }


        return $this->redirectToRoute('app_users');
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ProfileFormType;
use App\Form\User1Type;
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
    #[Route('/dashbord', name: 'app_dashbord')]
    public function dashbord(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('admin/dashbord.html.twig', [
            'users' => $users,
        ]);
    }
    /*#[Route('/indexx', name: 'app_userad')]
    public function indexx(): Response
    {
       
        
        return $this->render('Client/index.html.twig');
    }*/
    #[Route('/adminProfile', name: 'app_profile_admin')]
    public function editAdminProfile(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //*********change details************
       
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        //can make submit button here ...
        //dd($form);
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
        $form = $this->createForm(User1Type::class, $user);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('notice', "User has changed with success!");
            return $this->redirectToRoute('app_users');
        }

        return $this->render('admin/editUser.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'app_user_delete')]
    public function delete(UserRepository $repo, $id, EntityManagerInterface $entityManager): Response
    {
        $user = $repo->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('notice',"User is deleted!");
        return $this->redirectToRoute('app_users');
    }
}

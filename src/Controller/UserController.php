<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    #[Route('/user/Profile', name: 'user')]
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
    #[Route('/', name: 'app_home')]
    public function indexx(): Response
    {
        return $this->render('Client/index.html.twig');
    }
}
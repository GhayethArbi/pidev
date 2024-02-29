<?php

namespace App\Controller;

use App\Form\EmailType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $repo): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute("app_login");
    }

    #[Route(path: '/forgot', name: 'forgot')]
    public function forgotPassword(Request $request, UserRepository $userRepo, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $em): Response
    {


        $this->addFlash('danger', "this email is not exist");
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepo->findOneBy(['email' => $data]);
            if (!$user) {
                $this->addFlash('danger', "this email is not exist");
                return $this->redirectToRoute("app_home");
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

                $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                $email = (new Email())
                    ->from('gayeth.arbi@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Forgot Password')
                    ->html("<p>Hello,</p> there is a request to reset your password. Click <a href='$url'>here</a>.");
                $mailer->send($email);
                $this->addFlash('message', 'Email for password reset has been sent.');
            } catch (\Exception  $exception) {
                $this->addFlash('warning', 'An error occurred :' . $exception->getMessage());
                return $this->redirectToRoute("app_login");
            }
            return $this->redirectToRoute("app_home");
        }
        return $this->render("security/forgotPassword.html.twig", ['form' => $form->createView()]);
    }
    #[Route(path: '/mailer', name: 'app_mailer')]
    public function test(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(EmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData(['email']);
            //dd($user['email']);
            $email = (new Email())
                ->from('ghayeth.arbi@esprit.tn')
                ->to($user['email'])
                ->subject('test Succeful')
                ->text('Sending emails is fun')
                ->html('<p>See Twig integration for better HTML integration!</p>');
            try{
                $mailer->send($email);
                dd($mailer, $email);
        }catch (TransportExceptionInterface $e) {
            dd($e);
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }
        }
        return $this->render("security/test.html.twig", ['form' => $form->createView()]);
    }
}

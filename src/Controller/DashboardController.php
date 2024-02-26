<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/user', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('/user/plan_nutrtionnel/index.html.twig', []);
    }
}

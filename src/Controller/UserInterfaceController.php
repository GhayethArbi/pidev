<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserInterfaceController extends AbstractController
{
    #[Route('/user/interface', name: 'app_user_interface')]
    public function index(): Response
    {
        return $this->render('user_interface/index.html.twig');
    }
    #[Route('/user/product', name: 'app_user_product')]
    public function product(): Response
    {
        return $this->render('user_interface/product.html.twig');
    }
}

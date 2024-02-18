<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserInterfaceController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    #[Route('/user/interface', name: 'app_user_interface')]
    public function index(): Response
    {
        return $this->render('user_interface/index.html.twig');
    }

    #[Route('/user/product2', name: 'app_product_index_front', methods: ['GET'])]
    public function indexFront(ProductRepository $productRepository, Request $request): Response
    {
        $categoryId = $request->query->get('category');
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('user_interface/product2.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId, // Pass categoryId to Twig template
        ]);
    }
}

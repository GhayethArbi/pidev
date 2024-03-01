<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class UserInterfaceController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/interface', name: 'app_user_interface')]
    public function index(): Response
    {
        return $this->render('user_interface/index.html.twig');
    }

    /*#[Route('/user/product2', name: 'app_product_index_front', methods: ['GET'])]
    public function indexFront(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $categoryId = $request->query->get('category');
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        // Handle form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }

        // Paginate the products
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
            6 // Items per page
        );

        // Pass pagination to the template
        return $this->render('user_interface/product2.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId,
            'form' => $form->createView()
        ]);
    }*/
    #[Route('/user/product2', name: 'app_product_index_front', methods: ['GET'])]
    public function indexFront(ProductRepository $productRepository, Request $request): Response
    {
        $categoryId = $request->query->get('category');
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }

        // Added a return statement here
        return $this->render('user_interface/product2.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId, // Pass categoryId to Twig template
            'form' => $form->createView()
        ]);
    }
}
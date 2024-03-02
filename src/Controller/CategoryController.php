<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        // Récupérer toutes les catégories depuis la base de données
        $categories = $categoryRepository->findAll();

        // Récupérer les produits associés à chaque catégorie
        $categoryProducts = [];
        foreach ($categories as $category) {
            // Fetch products associated with the current category
            $products = $productRepository->findBy(['category' => $category]);
            $categoryProducts[$category->getName()] = $products;
        }

        // Récupérer tous les produits
        $products = $productRepository->findAll();

        // Récupérer uniquement les noms des catégories
        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[] = $category->getName();
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'categoryNames' => json_encode($categoryNames), // Convertir le tableau en chaîne JSON pour JavaScript
            'categoryProducts' => $categoryProducts, // Passer les produits associés à chaque catégorie à la vue
            'products' => $products, // Passer tous les produits à la vue
        ]);
    }
    #[Route('/category/{categoryId}', name: 'app_category_show')]
    public function show(Request $request, EntityManagerInterface $entityManager, int $categoryId): Response
    {
        // Retrieve the Category object from the database
        $category = $entityManager->getRepository(Category::class)->find($categoryId);

        // Check if the Category object exists
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        // Render the template with the Category object
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }



    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    #[Route('/search', name: 'app_search_products_by_category', methods: ['GET'])]
    public function searchProductsByCategory(Request $request, ProductRepository $productRepository): Response
    {
        $searchedCategory = $request->query->get('category');

        // Fetch products associated with the searched category
        $products = $productRepository->findByCategory($searchedCategory);

        return $this->render('category/search_results.html.twig', [
            'products' => $products,
            'searchedCategory' => $searchedCategory, // Pass the searched category to the template
        ]);
    }
    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/product')]
class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $maxProductsPerPage = 10;
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $products = $productRepository->findAll();
        // Calculate the total number of products
        $totalProducts = count($products);

        // Aggregate data for chart
        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[$category->getName()] = count($category->getProducts());
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'categoryData' => $categoryData, // Pass aggregated data to Twig
            'maxProductsPerPage' => $maxProductsPerPage,
            'totalProducts' => $totalProducts,
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle other form fields
            $product->setQuantite($form->get('quantite')->getData());

            // Handle illustration file upload
            $uploadedFile = $form['illustrationFile']->getData();
            if ($uploadedFile) {
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $uploadsDirectory,
                    $filename
                );
                $product->setIllustration($filename);
            }

            // Set slug
            $product->setSlug($slugger->slug($product->getName())->lower());

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload for edit action
            $uploadedFile = $form['illustrationFile']->getData(); // Corrected to match your form field name

            if ($uploadedFile) { // Check if a new file was uploaded
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $uploadsDirectory,
                    $filename
                );

                // Set the new filename to your entity
                $product->setIllustration($filename); // Assuming 'illustration' is the property where you store the filename
            }

            // Persist the product entity regardless of whether a file was uploaded or not
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index');
    }
}

<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
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
            $this->entityManager=$entityManager;
        }
        /*#[Route('/ff', name: 'app_product_index')]
        public function index(): Response
        {
            // Récupère toutes les catégories
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

            // Récupère tous les produits
            $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

            return $this->render('test.html.twig', [
                'categories' => $categories,
                'products' => $products,
            ]);
        }*/
       #[Route('/', name: 'app_product_index', methods: ['GET'])]
        public function index(ProductRepository $productRepository): Response
        {
            $categories = $this->entityManager->getRepository(Category::class)->findAll();
            return $this->render('product/index.html.twig', [
                'products' => $productRepository->findAll(),
                'categories' => $categories,

            ]);
        }






        #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $product->setSlug($slugger->slug($product->getName())->lower());
            $uploadedFile = $form['illustrationFile']->getData(); // Corrected to match your form field name

            if ($uploadedFile) { // Check if a file was uploaded
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $uploadsDirectory,
                    $filename
                );

                // Set the filename to your entity
                $product->setIllustration($filename); // Assuming 'illustration' is the property where you store the filename
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
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

            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            // Retrieve the filename of the image associated with the product
            $imageFilename = $product->getIllustration(); // Assuming 'illustration' is the property where you store the filename

            // Delete the image file from the server
            if ($imageFilename) {
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $imagePath = $uploadsDirectory . '/' . $imageFilename;

                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file from the server
                }
            }

            // Remove the product entity
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }


    /*public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug'),
            ImageField::new('illustration'),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('price'),
            AssociationField::new('category')
            // If you want to customize the category field, you can do it like this:
            // AssociationField::new('category'),
        ];
    }*/
}

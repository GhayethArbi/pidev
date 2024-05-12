<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Panier;
use App\Entity\Product;
use App\Repository\PanierRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    private $entityManager;
    private $productRepository;



    public function __construct(EntityManagerInterface $entityManager, ProductRepository $repo)
    {
        $this->entityManager = $entityManager;
        $this->productRepository=$repo;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->findAll();
        return $this->render('cart/index.html.twig', [
            'cart' => $panier,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_cart_item')]
    public function add($id, PanierRepository $repo): Response
    {
        $product=$this->productRepository->find($id);
        $cart=$repo->findOneBy(['product' => $product]);
        if($cart==null)
        {
        $cart=new Panier();
        $cart->setProduct($product);
        $cart->setQuantite(1);
        $cart->setTotalPrice($product->getPrice());
        $cart->setUser($this->getUser());
        }else{
            $cart->setQuantite($cart->getQuantite()+1); 
        }
        $this->entityManager->persist($cart);

        $this->entityManager->flush();
        // You can perform logic here to add the item to the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after adding item
    }

    #[Route('/cart/delete/{id}', name: 'delete_cart_item')]
    public function delete($id, PanierRepository $repo): Response
    {
        $product=$repo->find($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_cart_item')]
    public function decrease($id,  PanierRepository $repo): Response
    {
        $produit=$repo->find($id);

        if($produit->getQuantite()>1){
            $produit->setQuantite($produit->getQuantite()-1);
            $this->entityManager->persist($produit);
        }else{
            $this->entityManager->remove($produit);
        }
        $this->entityManager->flush();
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }

    #[Route('/cart/validate', name: 'validate_cart')]
    public function validateCart(Cart $cart, EntityManagerInterface $entityManager): Response
    {
        // Get the cart contents
        $cartItems = $cart->getFull();

        // Update the product quantities
        foreach ($cartItems as $cartItem) {
            $product = $cartItem['product'];
            $quantityAdded = $cartItem['quantity'];

            // Subtract the quantity added to the cart from the total product quantity
            $product->setQuantite($product->getQuantite() - $quantityAdded);
            $entityManager->persist($product);
        }
        $cart->checkProductQuantity();
        // Clear the cart after validation
        $cart->remove();

        // Flush changes to the database
        $entityManager->flush();

        // Redirect to a success page or wherever needed
        return $this->redirectToRoute('create_commande');
    }
}

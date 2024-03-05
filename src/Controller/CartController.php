<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        }

    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        $cart->checkProductQuantity();
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_cart_item')]
    public function add($id, Cart $cart): Response
    {
        $cart->add($id);
        // You can perform logic here to add the item to the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after adding item
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_cart_item')]
    public function decrease($id, Cart $cart): Response
    {
        $cart->decrease($id);
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }

    #[Route('/cart/delete/{id}', name: 'delete_cart_item')]
    public function delete($id, Cart $cart): Response
    {
        $cart->delete($id);
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
        return $this->redirectToRoute('create_order');
    }

}

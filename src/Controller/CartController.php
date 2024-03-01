<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart)
    {
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

    #[Route('/cart/remove', name: 'remove_cart_item')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }
    #[Route('/cart/delete/{id}', name: 'delete_produit')]
    public function delete(Cart $cart,$id): Response
    {
        $cart->delete($id);
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }
    #[Route('/cart/decrease/{id}', name: 'decrease_produit')]
    public function decrease(Cart $cart,$id): Response
    {
        $cart->decrease($id);
        // You can perform logic here to remove the item from the cart
        return $this->redirectToRoute('app_cart'); // Redirect to cart page after removing item
    }
}

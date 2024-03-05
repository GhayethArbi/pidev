<?php
namespace App\Controller;

use App\Entity\User; // Add this line to import the User entity
use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailjetService;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MailjetService $mailjetService)
    {
        $this->entityManager = $entityManager;
        $this->mailjetService = $mailjetService;
    }

    #[Route('/order', name: 'create_order')]
    public function create(Request $request, Cart $cart ,MailjetService $mailjetService): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();

        // Create a new Order object
        $order = new \stdClass();
        $order->email = $user->getEmail();
        $order->address = $user->getAddress();

        // Save the order to the database (if necessary)

        // You can perform further actions here, such as sending confirmation emails, etc.

        // Redirect to a success page or wherever needed
        return $this->redirectToRoute('create_order_success');
    }

    #[Route('/order/success', name: 'create_order_success')]
    public function createOrderSuccess(): Response
    {
        // You can render a success page here if needed
        return $this->render('order/success.html.twig');
    }
}
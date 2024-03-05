<?php
namespace App\Classe;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twilio\Rest\Client;

class Cart
{
    private $session;
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager,SessionInterface $session,)
    {
        $this->session=$session;
        $this->entityManager = $entityManager;

    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        // Retrieve the product
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        // Check if the product exists
        if (!$product) {
            return; // Do nothing if the product doesn't exist
        }

        // Check if the product has enough quantity in stock
        if ($product->getQuantite() <= 0) {
            return; // Do nothing if the product is out of stock
        }

        // Add the product to the cart or increase its quantity if already in the cart
        if(!empty($cart[$id]))
        {
            $cart[$id]++;
        }
        else
        {
            $cart[$id]=1;
        }



        $this->session->set('cart', $cart);
    }


    public function get()
    {
        return $this->session->get('cart');
    }
    public function remove()
    {
        return $this->session->remove('cart');
    }
    public function delete($id)
    {
        $cart = $this->session->get('cart', []);
        unset($cart[$id]);
        return $this->session->set('cart', $cart);
    }
    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);
        if($cart[$id]>1)
        {
            $cart[$id]--;
        }
        else
        {
            unset($cart[$id]);
        }
        return $this->session->set('cart',$cart);
    }
    public function getFull()
    {
        $cartComplete = [];
        if($this->get())
        {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

                if(!$product_object)
                {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }
    public function checkProductQuantity()
    {
        $cart = $this->session->get('cart', []);

        foreach ($cart as $id => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->find($id);

            if ($product && $product->getQuantite() === 0) {
                // Trigger SMS notification
                $sid = "ACacecc750024966258be4ef1c74c3cfe7"; // Your Twilio SID
                $token = "3b445010e6bf2d74796ceb0ac34d9184"; // Your Twilio Auth Token
                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create("+21656688168",
                        array(
                            "from" => "+12242796337",
                            "body" => "Product Sold Out: " . $product->getName() . " has no quantity anymore."
                        )
                    );

                print($message->sid);
            }
        }
    }
}
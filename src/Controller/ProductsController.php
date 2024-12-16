<?php
namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        // Handle the GET request to display products and cart data
        if ($request->isMethod('GET')) {
            // Get all products from the database
            $products = $entityManager->getRepository(Product::class)->findAll();

            // Collect products data into an array
            $productData = [];
            foreach ($products as $product) {
                $productData[] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice(),
                    'stock' => $product->getStock(),
                    'imgURL' => $product->getImgURL(),
                    'categories' => array_map(fn($category) => $category->getName(), $product->getCategories()->toArray()),
                ];
            }

            // Collect all categories from products
            $allCategories = [];
            foreach ($productData as $product) {
                foreach ($product['categories'] as $category) {
                    $allCategories[] = $category;
                }
            }

            // Remove duplicate categories using array_unique
            $uniqueCategories = array_unique($allCategories);

            // Fetch cart items for the current user
            $cartItems = $entityManager->getRepository(Cart::class)->findBy(['user' => $this->getUser()]);

            $cartData = [];
            $totalCartPrice = 0;

            // Prepare cart data with product name, quantity, and total price
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->getProduct();
                $quantity = $cartItem->getQuantity();
                $price = $product->getPrice() * $quantity;

                $cartData[] = [
                    'productName' => $product->getName(),
                    'quantity' => $quantity,
                    'price' => $price,
                ];

                $totalCartPrice += $price;
            }

            // Render the Twig template and pass product data, categories, and cart data
            return $this->render('products/index.html.twig', [
                'products' => $productData,
                'categories' => $uniqueCategories,  // Pass unique categories to the template
                'cart' => $cartData,                // Pass the cart data to the template
                'totalCartPrice' => $totalCartPrice, // Pass the total price of the cart
            ]);
        }

        // Handle the POST request for adding items to the cart
        if ($request->isMethod('POST') && $request->get('action') === 'add-to-cart') {
            $productId = $request->request->get('productId');
            $quantity = $request->request->get('quantity', 1);

            $product = $entityManager->getRepository(Product::class)->find($productId);

            if (!$product) {
                return $this->json(['status' => 'error', 'message' => 'Product not found']);
            }

            $cart = new Cart();
            $cart->setProduct($product);
            $cart->setQuantity($quantity);
            $cart->setUser($this->getUser());

            try {
                $entityManager->persist($cart);
                $entityManager->flush();

                return $this->json(['status' => 'success', 'message' => 'Product added to cart']);
            } catch (\Exception $e) {
                return $this->json(['status' => 'error', 'message' => 'Failed to add product to cart']);
            }
        }

        return $this->redirectToRoute('app_home');
    }
}

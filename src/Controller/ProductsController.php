<?php
// src/Controller/ProductsController.php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(EntityManagerInterface $entityManager)
    {
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

        // Render the Twig template and pass the product data and unique categories
        return $this->render('products/index.html.twig', [
            'products' => $productData,
            'categories' => $uniqueCategories,  // Pass the unique categories to the template
        ]);
    }
}

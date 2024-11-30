<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Sale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create Specific Categories
        $categoryNames = ['Chairs', 'Tables', 'Sofas', 'Beds'];
        $categories = [];
        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name)
                     ->setDescription("Description for $name");
            $manager->persist($category);
            $categories[] = $category; // Store as a numerically indexed array
        }

        // Create Products
        $products = [];
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName("Product $i")
                    ->setDescription("Description for Product $i")
                    ->setPrice(mt_rand(10, 100))
                    ->setStock(mt_rand(1, 50))
                    ->setImgUrl("https://via.placeholder.com/150?text=Product+$i");

            // Randomly assign product to one category
            $randomCategory = $categories[array_rand($categories)];
            $product->addCategory($randomCategory);

            $manager->persist($product);
            $products[] = $product;
        }

        // Create Orders
        for ($i = 1; $i <= 5; $i++) {
            $order = new Order();
            $order->setCreatedAt(new \DateTime("now - $i days"))
                  ->setStatus(['Pending', 'Completed', 'Cancelled'][array_rand([0, 1, 2])]);
            $manager->persist($order);

            // Assign random products to orders
            $randomProducts = array_rand($products, mt_rand(1, 4));
            foreach ((array) $randomProducts as $index) {
                $products[$index]->setProductOrders($order);
            }
        }

        // Create Sales
        for ($i = 1; $i <= 5; $i++) {
            $sale = new Sale();
            $sale->setSaleDate(new \DateTime("now - $i months"))
                 ->setTotalAmount(mt_rand(100, 1000));
            $manager->persist($sale);

            // Assign random products to sales
            $randomProducts = array_rand($products, mt_rand(1, 3));
            foreach ((array) $randomProducts as $index) {
                $products[$index]->setProductSales($sale);
            }
        }

        // Save all entities
        $manager->flush();
    }
}

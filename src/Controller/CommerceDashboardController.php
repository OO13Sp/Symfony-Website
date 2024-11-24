<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommerceDashboardController extends AbstractController
{
    #[Route('/commerce/dashboard', name: 'app_commerce_dashboard')]
    public function index(): Response
    {
        return $this->render('commerce_dashboard/index.html.twig', [
            'controller_name' => 'CommerceDashboardController',
        ]);
    }
}

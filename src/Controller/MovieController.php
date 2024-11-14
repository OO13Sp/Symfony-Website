<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{name}', name: 'app_movie', defaults: ['name' => null], methods: ['GET', 'HEAD'])]
    public function index($name): Response
    {
        return $this->render('movie/index.html.twig', [
        
            'controller_name' => 'MovieController',
            'message' => $name,
            'stupid' => 'damn'
        ]);
    }
}

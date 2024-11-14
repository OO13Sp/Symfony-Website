<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function index(Request $request): Response
    {
        // If you want to handle the form data, you can access $request->request->get('field_name')
        
        return $this->render('signup/index.html.twig', [
            'controller_name' => 'SignupController',
            // Add additional data to pass to the template if needed
        ]);
    }
}

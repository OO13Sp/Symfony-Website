<?php
// src/Controller/LoginController.php
// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'simple_login_form')]
    public function showForm(Request $request): Response
    {
        // Handle the form submission
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
            // Here, you can process the form data as needed

            // Display success message or redirect, if necessary
            return $this->render('login/success.html.twig', [
                'formData' => $formData,
            ]);
        }

        // Display the form template
        return $this->render('login/index.html.twig');
    }
}

<?php
// src/Controller/RatulController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Demo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user', name: 'user_controller')]
    public function index(): Response
    {
        // Fetch data from the database
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $demos = $this->entityManager->getRepository(Demo::class)->findAll();

        // Pass data to the view
        return $this->render('user/index.html.twig', [
            'message' => 'UserController',
            'users' => $users,
            'demos' => $demos,
        ]);
    }
}

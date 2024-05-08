<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class AuthenticationController extends AbstractController
{
    #[Route('/authentication', name: 'app_authentication')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthenticationController.php',
        ]);
    }

    #[Route(path: '/ping', name: 'post_create', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json(['pong']);
    }
}

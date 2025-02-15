<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/api')]
class PingController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using jwt_login in your security.yaml');
    }

    #[Route('/api/token', name: 'api_get_token', methods: ['POST'])]
    public function getToken(UserInterface $user, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        return new JsonResponse(['token' => $jwtManager->create($user)]);
    }

    #[Route(path: '/ping', name: 'ping', methods: [Request::METHOD_GET])]
    public function unauthenticated(): Response
    {
        return new JsonResponse(['message' => 'pong'], Response::HTTP_OK);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route(path: '/ping_auth', name: 'ping_authenticated', methods: [Request::METHOD_GET])]
    public function authenticated(): Response
    {
        return new JsonResponse(['message' => 'pong'], Response::HTTP_OK);
    }
}

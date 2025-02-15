<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\Authenticator;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

readonly class JwtAuthenticator implements AuthenticatorInterface, AuthenticationEntryPointInterface
{
    /**
     * @param UserProviderInterface<UserInterface> $userProvider
     */
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private UserProviderInterface $userProvider,
        private Security $security,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if (null === $authorizationHeader || !str_starts_with(strtolower($authorizationHeader), 'bearer')) {
            throw new AuthenticationException('Invalid authorization header.');
        }

        $token = $this->security->getToken();
        if (!$token instanceof TokenInterface) {
            throw new AuthenticationException('No valid token found.');
        }

        try {
            $payload = $this->jwtManager->decode($token);
            if (!is_array($payload) || !array_key_exists('username', $payload)) {
                throw new AuthenticationException('Invalid JWT Token payload.');
            }

            /** @var string $userIdentifier */
            $userIdentifier = $payload['username'];

            return new SelfValidatingPassport(
                new UserBadge($userIdentifier, function ($userIdentifier) {
                    return $this->userProvider->loadUserByIdentifier($userIdentifier);
                })
            );
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid JWT Token');
        }
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new PostAuthenticationToken(
            $passport->getUser(),
            $firewallName,
            $passport->getUser()->getRoles()
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $passport = $this->authenticate($request);

        return new JsonResponse(
            [
                'message' => 'Authentication Successful',
                'token' => $this->createToken($passport, $firewallName),
            ],
            Response::HTTP_OK,
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['message' => 'Authentication Failed: '.$exception->getMessage()], Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['message' => 'Authentication Required'], Response::HTTP_UNAUTHORIZED);
    }
}

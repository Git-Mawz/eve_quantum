<?php

namespace App\Security;

use App\Service\EveOauth2;
use App\Service\UserChecker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class EveOnlineAuthenticator extends AbstractGuardAuthenticator
{   

    public const LOGIN_ROUTE = 'app_login';

    private $userChecker;
    private $eveOauth2;
    private $session;
    // private $resourceOwner;
    // private $accessToken;


    public function __construct(UserChecker $userChecker, SessionInterface $session, EveOauth2 $eveOauth2)
    {
        $this->session = $session;
        $this->userChecker = $userChecker;
        $this->eveOauth2 = $eveOauth2;
      
    }

    public function supports(Request $request)
    {
        // if ($this->session->get('resourceOwner')) {
        //     return false;
        // }

        // return true;

        return self::LOGIN_ROUTE === $request->attributes->get('_route');

    }

    public function getCredentials(Request $request)
    {
        return $this->eveOauth2->authenticate();
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {   
        $user = $this->userChecker->checkUser($credentials);
        // $this->currentUser = $user;
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $this->session->set('resourceOwner', $this->eveOauth2->getResourceOwner());
        $this->session->set('accessToken', $this->eveOauth2->getAccessToken());
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        // todo
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

}

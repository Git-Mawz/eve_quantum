<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\UserChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class EveOnlineAuthenticator extends AbstractGuardAuthenticator
{   

    private $userChecker;
    private $credentials;
    private $provider;
    private $session;

    public function __construct(UserChecker $userChecker, SessionInterface $session)
    {
        $this->session = $session;
        $this->userChecker = $userChecker;
        $this->provider = new \Killmails\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV["CLIENT_ID"],
            'clientSecret'      => $_ENV["SECRET_KEY"],
            'redirectUri'       => 'http://localhost:8000/login',
        ]);
    }

    public function supports(Request $request)
    {
        return false;
    }

    public function getCredentials(Request $request)
    {
        $resourceOwner = $this->session->get('resourceOwner');
        return $resourceOwner;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {   
        $user = $this->userChecker->checkUser($credentials);
        $this->currentUser = $user;
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}

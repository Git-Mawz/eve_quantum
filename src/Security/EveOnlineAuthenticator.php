<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\UserChecker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
    private $session;
    private $resourceOwner;
    private $accessToken;


    public function __construct(UserChecker $userChecker, SessionInterface $session)
    {
        $this->session = $session;
        $this->userChecker = $userChecker;
      
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
        $provider = new \Killmails\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV["CLIENT_ID"],
            'clientSecret'      => $_ENV["SECRET_KEY"],
            'redirectUri'       => 'http://localhost:8000/login',
        ]);
        
        // If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {
        
            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $options = [
                'scope' => ['esi-mail.read_mail.v1', 'esi-mail.send_mail.v1'] // array or string
            ];
            
            $authorizationUrl = $provider->getAuthorizationUrl($options);
        
            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);
            exit;
        
        } else {
        
            try {
        
                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
        
                $resourceOwner = $provider->getResourceOwner($accessToken);
                
                $this->resourceOwner = $resourceOwner;
                $this->accessToken = $accessToken;

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        
                // Failed to get the access token or user details.
                exit($e->getMessage());
        
            }

            return $resourceOwner;

        }
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
        $this->session->set('resourceOwner', $this->resourceOwner);
        $this->session->set('accessToken', $this->accessToken);
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

    // protected function getLoginUrl()
    // {
    //     return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    // }

}

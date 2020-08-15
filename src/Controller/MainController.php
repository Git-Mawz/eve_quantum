<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/login", name="main_login")
     */
    public function login(SessionInterface $session)
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
        
            // // Get the state generated for you and store it to the session.
            // $_SESSION['oauth2state'] = $provider->getState();
        
            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);
            exit;
        
        // // Check given state against previously stored one to mitigate CSRF attack
        // } elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
        
        //     if (isset($_SESSION['oauth2state'])) {
        //         unset($_SESSION['oauth2state']);
        //     }
        
        //     exit('Invalid state');
        
        } else {
        
            try {
        
                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
        
                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                // echo 'Access Token: ' . $accessToken->getToken() . "<br>";
                // echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
                // echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
                // echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";
        
                // Using the access token, we may look up details about the
                // resource owner.
                $resourceOwner = $provider->getResourceOwner($accessToken);

                $session->set('resourceOwner', $resourceOwner);
                $session->set('accessToken', $accessToken);
        
                // var_export($resourceOwner->toArray());

        
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        
                // Failed to get the access token or user details.
                exit($e->getMessage());
        
            }
        
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/home", name="main_home")
     */
    public function home ()
    {
        return $this->render('main/home.html.twig', [
            'user' => $this->get('session')->get('resourceOwner')
        ]);
    }



}

<?php

namespace App\Service;

class EveOauth2
{
    public $resourceOwner;
    public $accessToken;
    
    public function getResourceOwner()
    {
        return $this->resourceOwner;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function authenticate()
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
}
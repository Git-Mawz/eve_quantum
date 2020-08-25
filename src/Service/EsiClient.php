<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EsiClient
{
    private $baseEsiUrl = 'https://esi.evetech.net/latest';
    private $provider; // Provider de la bibliothèque killmails/oauth2-eve
    private $client; // Client permettant d'interroger les routes de l'ESI (Eve Swagger Interface)
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        $this->client = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $session->get('accessToken')->getToken(),
                'User-Agent' => 'Eve Quantum',
                ]
            ]);

        // Utile si on souhaite refresh le token avec la méthode refreshToken
        $this->provider = new \Killmails\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV["CLIENT_ID"],
            'clientSecret'      => $_ENV["SECRET_KEY"],
            'redirectUri'       => 'http://localhost:8000/login',
            ]);

    }

    // Logique de cette méthode utilisé dans l'event kernel.request avec l'event suscriber EveTokenFrefreshSubscriber.php
    // Cette méthode reste ici afin d'avoir un moyen de refresh manuellement le token sur la route /test/refreshToken
    public function refreshToken()
    {
        $existingAccessToken = $this->session->get('accessToken');
        
        if ($existingAccessToken->hasExpired()) {
            $newAccessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $existingAccessToken->getRefreshToken()
                ]);
        
            $this->session->set('accessToken', $newAccessToken);
        }
    }

    public function sendInGameMail($sender, $receiver)
    {   
        $response = $this->client->request('POST', $this->baseEsiUrl . '/characters/' . $sender . '/mail', [
            'json' => array (
                'approved_cost' => 0,
                'body' => 'test symfony',
                'recipients' => 
                array (
                  0 => 
                  array (
                    'recipient_id' => $receiver,
                    'recipient_type' => 'character',
                  ),
                ),
                'subject' => 'test symfo',
              )
        ]);

    }

    public function setDestination($destinationId)
    {
        $response = $this->client->request('POST', $this->baseEsiUrl . '/ui/autopilot/waypoint/', [
            'query' => [
                'add_to_beginning' => false,
                'clear_other_waypoints' => false,
                'destination_id' => $destinationId
            ]
        ]);
    }

}
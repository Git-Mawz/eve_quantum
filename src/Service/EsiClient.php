<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use App\Entity\Utils\EveMail;
use App\Entity\Utils\Recipients;

class EsiClient
{
    private $baseEsiUrl = 'https://esi.evetech.net/latest';
    private $provider; // Provider de la bibliothèque killmails/oauth2-eve
    private $client; // Client permettant d'interroger les routes de l'ESI (Eve Swagger Interface)
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->client = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $session->get('accessToken')->getToken(),
                'User-Agent' => 'Eve Quantum',
                ]
            ]);

        $this->provider = new \Killmails\OAuth2\Client\Provider\EveOnline([
            'clientId'          => $_ENV["CLIENT_ID"],
            'clientSecret'      => $_ENV["SECRET_KEY"],
            'redirectUri'       => 'http://localhost:8000/login',
            ]);

        $this->session = $session;
    }

    // Logique de cette méthode utilisé dans l'event kernel.request avec l'event suscriber EveTokenFrefreshSubscriber.php
    // Cette méthode reste ici afin d'avoir un moyen de refresh manuellement le token sur la route /test/refreshToken
    public function RefreshToken()
    {
        $existingAccessToken = $this->session->get('accessToken');
        
        if ($existingAccessToken->hasExpired()) {
            $newAccessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $existingAccessToken->getRefreshToken()
                ]);
        
            $this->session->set('accessToken', $newAccessToken);
        }
    }

    // Permet de récupérer les 50 derniers mails d'un personnage dont on connait le characterId
    public function getCharacterMail($characterId)
    {
        $response = $this->client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId . '/mail');
        $jsonContent = $response->getContent();
        $mails = json_decode($jsonContent);
        
        return $mails;
    }

    public function sendInGameMail($characterId)
    {   
        $response = $this->client->request('POST', $this->baseEsiUrl . '/characters/' . $characterId . '/mail', [
            'body' => [
                'mail' => array (
                    'approved_cost' => 0,
                    'body' => 'test2',
                    'recipients' => array (
                        0 => array (
                            'recipient_id' => '2113085965',
                            'recipient_type' => 'character',
                        ),
                    ),
                    'subject' => 'test2',
                  )
            ]
        ]);
        // $response->getContent();
    }

    public function setDestination()
    {
        $response = $this->client->request('POST', $this->baseEsiUrl . '/ui/autopilot/waypoint/', [
            'query' => [
                'add_to_beginning' => false,
                'clear_other_waypoints' => false,
                'destination_id' => 30000142 // Jita
            ]
        ]);
    }

}
<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Where all usefull methods are stored to consume ESI
 * https://esi.evetech.net/ui/
 * @author Mawz 
 */

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

    /**
     * Allow to refresh manually Eve Online Token with the refresh token
     *
     * @return void
     */
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

    /**
     * Allow to send and Eve mail
     *
     * @param integer $sender characterId of the sender (get it in controllers with $this->getUser())
     * @param integer $receiver characterId of the character you want to send the mail to
     * @param string $subject subject of the Eve mail
     * @param string $body body/content of the Eve mail
     * @return void
     */
    public function sendInGameMail($sender, $receiver, $subject, $body)
    {   
        $response = $this->client->request('POST', $this->baseEsiUrl . '/characters/' . $sender . '/mail', [
            'json' => array (
                'approved_cost' => 0,
                'body' => $body,
                'recipients' => 
                array (
                  0 => 
                  array (
                    'recipient_id' => $receiver,
                    'recipient_type' => 'character',
                  ),
                ),
                'subject' => $subject,
              )
        ]);

    }

    /**
     * Allow to set a solar system as a destination in game with his destination_id
     *
     * @param interger $destinationId destination_id of the system you want to set the destination to
     * @return void
     */
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

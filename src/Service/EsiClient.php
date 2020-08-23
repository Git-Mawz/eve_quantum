<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EsiClient
{
    private $baseEsiUrl = 'https://esi.evetech.net/latest';

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getCharacterMail($characterId)
    {
        $accessToken = $this->session->get('accessToken')->getToken();

        // On créé le client pour la requête
        $client = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'User-Agent' => 'Krawks',
            ]
        ]);

        $response = $client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId . '/mail');
        $jsonContent = $response->getContent();
        $mails = json_decode($jsonContent);
        
        return $mails;
    }
}
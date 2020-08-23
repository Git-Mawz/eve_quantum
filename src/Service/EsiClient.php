<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EsiClient
{
    private $baseEsiUrl = 'https://esi.evetech.net/latest';
    private $client;

    public function __construct(SessionInterface $session)
    {
        $this->client = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $session->get('accessToken')->getToken(),
                'User-Agent' => 'Krawks',
            ]
        ]);
    }

    public function getCharacterMail($characterId)
    {
        $response = $this->client->request('GET', $this->baseEsiUrl . '/characters/' . $characterId . '/mail');
        $jsonContent = $response->getContent();
        $mails = json_decode($jsonContent);
        
        return $mails;
    }

    public function sendInGameMail()
    {

    }
}
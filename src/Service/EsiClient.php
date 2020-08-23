<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class EsiClient
{
    private $baseEsiUrl = 'https://esi.evetech.net/latest';

    public function getCharacterMail($characterId)
    {
        //On récupère le token dans la session
        $tokens = $this->get('session')->get('token');
        // dd($tokens);
        $accessToken = $tokens->getToken('accessToken');

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
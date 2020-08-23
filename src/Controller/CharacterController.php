<?php

namespace App\Controller;

use App\Service\EsiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/profile", name="character_profile")
     */
    public function profile(EsiClient $esiClient)
    {
        $mails = $esiClient->getCharacterMail($this->getUser()->getEveCharacterId());
        dump($mails);

        return $this->render('character/profile.html.twig');
    }
}

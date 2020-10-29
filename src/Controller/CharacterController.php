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
        $user = $this->getUser();
        // on cherche si l'utilisateur à des question


        return $this->render('character/profile.html.twig', [
            'userQuestionsCount' => count($user->getQuestion()),
            'userAnswersCount' => count($user->getAnswer())
        ]);
    }
}

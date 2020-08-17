<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/profile", name="character_profile")
     */
    public function profile()
    {
        return $this->render('character/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}

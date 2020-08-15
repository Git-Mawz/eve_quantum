<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/sheet", name="character_sheet")
     */
    public function sheet()
    {
        return $this->render('character/sheet.html.twig', [
            'controller_name' => 'CharacterController',
        ]);
    }
}

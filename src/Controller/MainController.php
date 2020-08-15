<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="main_home")
     */
    public function home ()
    {
        return $this->render('main/home.html.twig', [
            'user' => $this->getUser()
        ]);
    }

}

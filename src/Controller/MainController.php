<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/login", name="main_login")
     */
    public function login(SessionInterface $session)
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

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

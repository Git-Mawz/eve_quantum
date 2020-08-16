<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="main_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/login", name="main_login")
     */
    public function login()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/about", name="main_about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/logout", name="main_logout")
     */
    public function logout()
    {
        $client = HttpClient::create();
        // We make a request to eve online logout route
        $client->request('GET', 'https://login.eveonline.com/Account/LogOff');
        // We clear session
        $session = $this->get('session');
        $session->clear();
        // We go back to home page
        return $this->redirectToRoute('main_home');
    }

}

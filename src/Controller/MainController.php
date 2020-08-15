<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
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
     * @Route("/home", name="main_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig', [
            'user' => $this->getUser()
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
        // On fait une requete vers la route de logoff d'eve online
        $client->request('GET', 'https://login.eveonline.com/Account/LogOff');
        // On vide la session
        $session = $this->get('session');
        $session->clear();
        // On retourne à la page d'accueil
        return $this->redirectToRoute('main_home');
    }

}

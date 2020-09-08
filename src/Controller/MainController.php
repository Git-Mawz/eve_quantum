<?php

namespace App\Controller;

use App\Entity\Suggest;
use App\Form\SuggestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/login", name="app_login")
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
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        $client = HttpClient::create();
        // We make a request to eve online logout route
        $client->request('GET', 'https://login.eveonline.com/Account/LogOff');
        // We clear session
        $session = $this->get('session');
        $session->clear();
        // // We go back to home page
        // return $this->redirectToRoute('main_home');

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }

    /**
     * @Route("/suggest", name="main_suggest")
     */

     public function suggest(Request $request)
     {
        $newSuggest = new Suggest();
        $form = $this->createForm(SuggestType::class, $newSuggest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $newSuggest->setCreatedAt(new \Datetime()); 
            if ($this->getUser()) {
                $newSuggest->setUser($this->getUser());
            }
            $em->persist($newSuggest);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre suggestion à bien été envoyé, merci !');

            return $this->redirectToRoute('character_profile');
        }


        return $this->render('main/suggest.html.twig', [
            'form' => $form->createView()
        ]);
     }

}


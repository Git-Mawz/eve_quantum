<?php

namespace App\Controller;

use App\Service\EsiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test", name="test_")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/refreshToken", name="refreshToken")
     */
    public function index(EsiClient $esiClient)
    {   
        $esiClient->refreshToken();

        dump($this->get('session')->get('accessToken'));

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function sendIngameMail(EsiClient $esiClient)
    {
        $subject = 'Hello';
        $body = 'This is a test content';
        $esiClient->sendIngameMail($this->getUser()->getEveCharacterId(), 2115511700, $subject, $body);

    }

    /**
     * @Route("/setdest", name="setdest")
     */
    public function setDestination(EsiClient $esiClient)
    {
        $esiClient->setDestination(30000142); // Jita 30000142
    }

}

<?php

namespace App\Controller\Api;

use App\Entity\SolarSystem;
use App\Repository\SolarSystemRepository;
use Doctrine\ORM\EntityManagerInterface;
use SolarSystemChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/character", name="api_character_")
 */
class CharacterController extends AbstractController
{
    /**
     * @Route("/solar_system", name="add_solar_system", methods={"POST"})
     */
    public function addFavoriteSystem(Request $request, EntityManagerInterface $em, SolarSystemRepository $solarSystemRepository, SolarSystemChecker $solarSystemChecker)
    {   
        $this->denyAccessUnlessGranted("ROLE_USER");

        $jsonData = json_decode($request->getContent(), true);

        $solarSystemUniverseId = $jsonData['systemUniverseId'];
        $solarSystemName = $jsonData['systemName'];

        // $newSolarSystem = new SolarSystem();
        // $newSolarSystem->setName($jsonData['systemName']);
        // $newSolarSystem->setUniverseId($jsonData['systemUniverseId']);

        // $em->persist($newSolarSystem);
   
        // $currentUser = $this->getUser();
        // $currentUser->addSolarSystem($newSolarSystem);

        // $em->flush();

        $solarSystem = $solarSystemChecker->saveSystemForUser($solarSystemUniverseId, $solarSystemName, $this->getUser());

        // return $this->json([
        //     'message' => $solarSystem->getName() . ' added to ' . $this->getUser()->getName() . '\'s favorite solar system',
        // ]);

        return $this->json([
            'message' => 'Solar System Added',
        ]);


    }

    /**
     * @Route("/solar_system/{universeId}", name="solar_system_delete", methods={"DELETE"})
     */
    public function removeFavoriteSystem(SolarSystem $solarSystem, Request $request, EntityManagerInterface $em)
    {
        // $this->denyAccessUnlessGranted("ROLE_USER");

        

        $currentUser = $this->getUser();
        $currentUser->removeSolarSystem($solarSystem);

        $em->flush();

        return $this->json([
            'message' => $solarSystem->getName() . ' removed from ' . $currentUser->getName() . '\'s favorite solar system',
        ]);

    }

}

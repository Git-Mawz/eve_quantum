<?php

namespace App\Controller\Api;

use App\Entity\SolarSystem;
use App\Service\FavoriteSolarSystemManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/character", name="api_character_")
 */
class CharacterController extends AbstractController
{
    /**
     * @Route("/solar_system", name="add_solar_system", methods={"POST"})
     */
    public function addFavoriteSystem(Request $request, FavoriteSolarSystemManager $favoriteSolarSystemManager)
    {   
        $this->denyAccessUnlessGranted("ROLE_USER");

        $jsonData = json_decode($request->getContent(), true);

        $currentUser = $this->getUser();
        $solarSystemUniverseId = $jsonData['systemUniverseId'];
        $solarSystemName = $jsonData['systemName'];

        $favoriteSolarSystemManager->checkSolarSystem($solarSystemUniverseId, $solarSystemName, $currentUser);

        return $this->json([
            'message' => 'Solar System added to user\'s favorites'
        ]);

    }

    /**
     * @Route("/solar_system/{universeId}", name="solar_system_delete", methods={"DELETE"})
     */
    public function removeFavoriteSystem(SolarSystem $solarSystem, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $currentUser = $this->getUser();
        $currentUser->removeSolarSystem($solarSystem);

        $em->flush();

        return $this->json([
            'message' => $solarSystem->getName() . ' removed from ' . $currentUser->getName() . '\'s favorite solar system',
        ]);

    }

    /**
     * @Route("/solar_system/", name="solar_system_browse", methods={"GET"})
     */
    public function browseFavoriteSystems (SerializerInterface $serializer)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $userFavoriteSolarSystems = $this->getUser()->getSolarSystems();
        $data = $serializer->normalize($userFavoriteSolarSystems, 'json', ['groups' => ['favorite_solar_system']]);

        return $this->json(['solarSystems' => $data]);
    }

}

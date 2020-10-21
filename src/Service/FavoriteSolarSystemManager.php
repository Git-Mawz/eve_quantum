<?php

namespace App\Service;

use App\Entity\SolarSystem;
use App\Entity\User;
use App\Repository\SolarSystemRepository;
use Doctrine\ORM\EntityManagerInterface;

class FavoriteSolarSystemManager
{

    private $solarSystemRepository;
    private $em;

    public function __construct(SolarSystemRepository $solarSystemRepository, EntityManagerInterface $em)
    {
        $this->solarSystemRepository = $solarSystemRepository;
        $this->em = $em;
    }

    public function checkSolarSystem($solarSystemUniverseId, $solarSystemName, User $user)
    {   
        $solarSystem = $this->solarSystemRepository->findOneBy(['universeId' => $solarSystemUniverseId]);

        if ($solarSystem instanceof SolarSystem) {
            $this->createRelation($solarSystem, $user);
            // return true;
        } else {
            $this->addSystemAndCreateRelation($solarSystemUniverseId, $solarSystemName, $user);
            // return false;
        }
    }

    private function createRelation (SolarSystem $solarSystem, User $user)
    {
        $user->addSolarSystem($solarSystem);
        $this->em->flush();
    }

    private function addSystemAndCreateRelation($solarSystemUniverseId, $solarSystemName, User $user)
    {
        $newSolarSystem = new SolarSystem();
        $newSolarSystem->setUniverseId($solarSystemUniverseId);
        $newSolarSystem->setName($solarSystemName);

        $this->em->persist($newSolarSystem);

        $user->addSolarSystem($newSolarSystem);

        $this->em->flush();

    }

}

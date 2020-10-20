<?php

use App\Entity\SolarSystem;
use App\Entity\User;
use App\Repository\SolarSystemRepository;
use Doctrine\ORM\EntityManagerInterface;

class SolarSystemChecker
{
    private $solarSystemRepository;
    private $em;

    public function __construct(SolarSystemRepository $solarSystemRepository, EntityManagerInterface $em){

        $this->solarSystemRepository = $solarSystemRepository;
        $this->em = $em;

    }

    /**
     * Check if solar system exist. If it do not exist function CREATE it in Database
     *
     * @param int $systemUniverseId
     * @param string $solarSystemName
     * @param User $user
     * @return SolarSystem $solarSystem
     */
    public function saveSystemForUser($systemUniverseId, $solarSystemName, User $user)
    {
        $solarSystem = $this->solarSystemRepository->findOneBy(['universeId' => $systemUniverseId]);

        if ($solarSystem instanceof SolarSystem) {
            $user->addSolarSystem($solarSystem);
            $this->em->flush();

            return $solarSystem;
            
        } else {

            $newSolarSystem = new SolarSystem();
            $newSolarSystem->setUniverseId($systemUniverseId);
            $newSolarSystem->setName($solarSystemName);
            $this->em->persist($newSolarSystem);
            $user->addSolarSystem($newSolarSystem);
            $this->em->flush();

            return $newSolarSystem;
        }

    }


}
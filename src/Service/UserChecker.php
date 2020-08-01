<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserChecker
{   
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function checkUser($credentials)
    {
        $storedUser = $this->userRepository->findOneBy(['character_owner_hash' => $credentials['CharacterOwnerHash']]);

        if ($storedUser == null) {
            $newUser = new User();
            $newUser->setName($credentials['CharacterName']);
            $newUser->setEveCharacterId($credentials['CharacterID']);
            $newUser->setCharacterOwnerHash($credentials['CharacterOwnerHash']);
            $newUser->setCreatedAt(new \DateTime());
            $newUser->setPortrait('https://images.evetech.net/Character/' . $credentials['CharacterID'] . '_128.jpg');

            $this->em->persist($newUser);
            $this->em->flush();

            $storedUser = $newUser;
        }

        return $storedUser;
    }
}
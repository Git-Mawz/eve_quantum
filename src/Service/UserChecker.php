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

    /**
     * Look for a user in DB or create it in case he do not exist
     * This method is linked to the getUser() method in the EveOnlineAuthenticator.php class
     *
     * @param mixed $credentials
     * @return void
     */
    public function checkUser($credentials)
    {
        $storedUser = $this->userRepository->findOneBy(['character_owner_hash' => $credentials->getCharacterOwnerHash()]);

        if ($storedUser == null) {
            $newUser = new User();
            $newUser->setName($credentials->getCharacterName());
            $newUser->setEveCharacterId($credentials->getCharacterID());
            $newUser->setCharacterOwnerHash($credentials->getCharacterOwnerHash());
            $newUser->setCreatedAt(new \DateTime());
            $newUser->setPortrait('https://images.evetech.net/Character/' . $credentials->getCharacterID() . '_256.jpg');

            $this->em->persist($newUser);
            $this->em->flush();

            $storedUser = $newUser;
        }

        return $storedUser;
    }
}
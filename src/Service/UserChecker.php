<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserChecker
{   
    private $userRepository;
    private $em;
    const CHARACTER_OWNER_HASH = 'character_owner_hash';
    const BASE_PORTRAIT_URL = 'https://images.evetech.net/Character/';
    const DEFAULT_JPG_FORMAT = '_256.jpg';

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
     * @return User
     */
    public function checkUser($credentials): User
    {
        $storedUser = $this->userRepository->findOneBy([static::CHARACTER_OWNER_HASH => $credentials->getCharacterOwnerHash()]);

        if ($storedUser == null) {
            $newUser = new User();
            $newUser->setName($credentials->getCharacterName());
            $newUser->setEveCharacterId($credentials->getCharacterID());
            $newUser->setCharacterOwnerHash($credentials->getCharacterOwnerHash());
            $newUser->setCreatedAt(new \DateTime());
            $newUser->setPortrait(static::BASE_PORTRAIT_URL . $credentials->getCharacterID() . static::DEFAULT_JPG_FORMAT);

            $this->em->persist($newUser);
            $this->em->flush();

            $storedUser = $newUser;
        }

        return $storedUser;
    }
}

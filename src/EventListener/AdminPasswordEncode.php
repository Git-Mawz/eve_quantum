<?php
 
namespace App\EventListener;

use App\Entity\Admin;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminPasswordEncode
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }



    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Admin) {
            return;
        }

        $plainPassword = $entity->getPassword();
        $encodedPassword = $this->encoder->encodePassword($entity, $plainPassword);

        $entity->setPassword($encodedPassword);

    }

    
}

<?php

namespace App\Controller\Api;

use App\Entity\Answer;
use App\Entity\Like;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/like", name="api_like_")
 */
class LikeController extends AbstractController
{
    
    /**
     * @Route("/add/{id}", name="add", methods={"POST"})
     */
    public function add(Answer $answer, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $currentUser = $this->getUser();


        $like = new Like();
        $like->setUser($currentUser);
        $like->setAnswer($answer);
        $em->persist($like);
        $em->flush();

        return $this->json([
            'message' => $currentUser->getName() . ' just liked the answer with ID ' . $answer->getId()
        ]);
    }

    /**
     * @Route("/count/{id}", name="count", methods={"GET"})
     */
    public function count(Answer $answer)
    {
        return $this->json([
            'likeCount' => count($answer->getLikes())
        ]);
    }


}

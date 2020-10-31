<?php

namespace App\Controller\Api;

use App\Entity\Answer;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/like", name="api_like_")
 */
class LikeController extends AbstractController
{
    
    /**
     * @Route("/toggle/{id}", name="toggle", methods={"POST"})
     */
    public function toggle(Answer $answer, EntityManagerInterface $em, LikeRepository $likeRepository)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $this->getUser();
        $like = $likeRepository->findIfUserAndAnswerMatchOnLike($user, $answer);
    
        if($like) {

            $user->removeLike($like);
            $answer->removeLike($like);
            $em->flush();

            return $this->json([
                'message' => $user->getName() . ' a enlever son like de la réponse de ' . $answer->getUser(),
                'likeCount' => count($answer->getLikes())
            ]);

        } else {
            
            $newLike = new Like();
            $newLike->setUser($user);
            $newLike->setAnswer($answer);
            $em->persist($newLike);
    
            $em->flush();
    
            return $this->json([
                'message' => $user->getName() . ' viens de like la réponse de ' . $answer->getUser(),
                'likeCount' => count($answer->getLikes())
            ]);

        }
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

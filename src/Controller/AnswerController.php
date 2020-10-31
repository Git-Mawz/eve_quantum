<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Like;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/answer", name="answer_")
 */
class AnswerController extends AbstractController
{

    /**
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(Answer $answer, Request $request)
    {
        if($answer->getUser() === $this->getUser() && $answer->getQuestion()->getIsClosed() !== true ) {
   
            $form = $this->createForm(AnswerType::class, $answer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $answer->setUpdatedAt(new \DateTime());
                $em->flush();
                // dd($answer->getQuestion()->getSlug());
                return $this->redirectToRoute('question_read', ['slug' => $answer->getQuestion()->getSlug()]);
            }
            
            return $this->render('answer/edit.html.twig', [
                'form' => $form->createView()
                ]);

        } else {
            return $this->redirectToRoute('question_list');
        }
    }

    /**
     * @Route("/{id}/toggle_like", name="toggle_like", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function toggleLike(Answer $answer, EntityManagerInterface $em, LikeRepository $likeRepository)
    {
        $user = $this->getUser();
        $like = $likeRepository->findIfUserAndAnswerMatchOnLike($user, $answer);
    
        if($like) {

            $user->removeLike($like);
            $answer->removeLike($like);
            $em->flush();

            return $this->redirectToRoute('question_read', ['slug' => $answer->getQuestion()->getSlug()]);

        } else {
            
            $newLike = new Like();
            $newLike->setUser($user);
            $newLike->setAnswer($answer);
            $em->persist($newLike);
    
            $em->flush();
    
            return $this->redirectToRoute('question_read', ['slug' => $answer->getQuestion()->getSlug()]);

        }

    }

}

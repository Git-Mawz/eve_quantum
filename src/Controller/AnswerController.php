<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Like;
use App\Form\AnswerType;
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
     * @Route("/{id}/add_like", name="add_like", requirements={"id"="\d+"}, methods={"POST"})
     */
    public function addLike(Answer $answer, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $like = new Like();
        $like->setUser($user);
        $like->setAnswer($answer);
        $em->persist($like);

        $em->flush();

        return $this->redirectToRoute('question_read', ['slug' => $answer->getQuestion()->getSlug()]);


    }

}

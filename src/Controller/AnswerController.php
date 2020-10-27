<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
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
        if($answer->getUser() === $this->getUser()) {
   
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
}

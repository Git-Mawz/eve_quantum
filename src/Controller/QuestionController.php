<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question", name="question_")
 */

class QuestionController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(QuestionRepository $questionRepository)
    {   
        // Exemple d'accès avec le role ROLE_USER necessaire
        // $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('question/list.html.twig', [
            'questions' => $questionRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(Question $question, Request $request)
    {   
        $newAnswer = new Answer();
        $form = $this->createForm(AnswerType::class, $newAnswer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $newAnswer->setUser($this->getUser());
            $newAnswer->setCreatedAt(new \DateTime());
            $newAnswer->setQuestion($question);
            $em->persist($newAnswer);
            $em->flush();

            return $this->redirectToRoute('question_read', ['id' => $question->getId()]);
        }

        return $this->render('question/read.html.twig', [
            'question' => $question,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */

    public function add(Request $request)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $newQuestion->setUser($this->getUser());
            $newQuestion->setCreatedAt(new \DateTime());
            $em->persist($newQuestion);
            $em->flush();

            return $this->redirectToRoute('question_list');
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

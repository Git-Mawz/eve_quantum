<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
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
    public function list()
    {   
        // Exemple d'accès avec le role ROLE_USER necessaire
        // $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('question/list.html.twig');
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(Question $question)
    {
        return $this->render('question/read.html.twig', [
            'question' => $question
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

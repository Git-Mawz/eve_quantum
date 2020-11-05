<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Service\QuestionSlugger;
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
    public function list(QuestionRepository $questionRepository, CategoryRepository $categoryRepository)
    {   
        // Exemple d'accès avec le role ROLE_USER necessaire
        // $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('question/list.html.twig', [
            'questions' => $questionRepository->findBy([], ['updatedAt' => 'DESC']),
            'categories' => $categoryRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="read_id", requirements={"id"="\d+"}, methods={"GET","POST"})
    //  */
    // public function read(Question $question, Request $request)
    // {   
    //     $newAnswer = new Answer();
    //     $form = $this->createForm(AnswerType::class, $newAnswer);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $this->denyAccessUnlessGranted('ROLE_USER');

    //         $em = $this->getDoctrine()->getManager();
    //         $newAnswer->setUser($this->getUser());
    //         $newAnswer->setCreatedAt(new \DateTime());
    //         $newAnswer->setQuestion($question);
    //         $em->persist($newAnswer);
    //         $em->flush();

    //         return $this->redirectToRoute('question_read_id', ['id' => $question->getId()]);
    //     }

    //     return $this->render('question/read.html.twig', [
    //         'question' => $question,
    //         'form' => $form->createView()
    //     ]);
    // }

    /**
     * @Route("/read/{slug}", name="read", methods={"GET","POST"}, requirements={})
     */
    public function readSlug(Question $question, Request $request)
    {   
        $newAnswer = new Answer();
        $form = $this->createForm(AnswerType::class, $newAnswer);


        if($question->getIsClosed() !== true) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->denyAccessUnlessGranted('ROLE_USER');
                $em = $this->getDoctrine()->getManager();

                $newAnswer->setUser($this->getUser());
                $newAnswer->setCreatedAt(new \DateTime());
                $newAnswer->setQuestion($question);

                $question->setUpdatedAt(new \DateTime());

                $em->persist($newAnswer);
                $em->flush();

                return $this->redirectToRoute('question_read', ['slug' => $question->getSlug()]);
            }  
        } else {
            // if question status isClosed === true we do not display any form
            // we add some controle in twig so there's no error in case variable 'form does not exist'
            return $this->render('question/read.html.twig', [
                'question' => $question,
            ]);
        }

        return $this->render('question/read.html.twig', [
            'question' => $question,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */

    public function add(Request $request, QuestionSlugger $questionSlugger)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $newQuestion->setUser($this->getUser());
            $newQuestion->setCreatedAt(new \DateTime());
            $newQuestion->setUpdatedAt(new \DateTime());
            $newQuestion->setSlug($questionSlugger->sluggifyQuestionTitle($newQuestion->getTitle()));

            $em->persist($newQuestion);
            $em->flush();

            return $this->redirectToRoute('question_list');
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{slug}", name="edit", methods={"GET","POST"})
     */
    public function edit(Question $question, Request $request, QuestionSlugger $questionSlugger)
    {

        if($question->getUser() === $this->getUser() && $question->getIsClosed() !== true) {
   
            $form = $this->createForm(QuestionType::class, $question);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $question->setSlug($questionSlugger->sluggifyQuestionTitle($question->getTitle()));
                // not necessary as we don't want edited subject to be bumped to the top of the list
                // $question->setUpdatedAt(new \DateTime());
                $em->flush();
                
                return $this->redirectToRoute('question_list');
            }
            
            return $this->render('question/edit.html.twig', [
                'form' => $form->createView()
                ]);
        } else {
            return $this->redirectToRoute('question_list');
        }
    }


}

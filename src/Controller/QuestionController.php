<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question", name="question_")
 */

class QuestionController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index()
    {
        return $this->render('question/list.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }
}

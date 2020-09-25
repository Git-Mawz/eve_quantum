<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/api/question", name="api_question")
     */
    public function index()
    {
        return $this->json([
            200,
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/QuestionController.php'
        ]);
    }
}

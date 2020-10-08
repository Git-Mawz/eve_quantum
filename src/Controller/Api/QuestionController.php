<?php

namespace App\Controller\Api;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/question", name="api_question_")
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/browse", name="browse")
     */
    public function browse(QuestionRepository $questionRepository, SerializerInterface $serializer)
    {
        $questions = $questionRepository->findAll();
        $data = $serializer->normalize($questions, 'json', ['groups' => ['question_browse']]);

        return $this->json(['questions' => $data]);
    }
}

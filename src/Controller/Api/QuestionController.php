<?php

namespace App\Controller\Api;

use App\Entity\Category;
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

    /**
     * @Route("/category/{id}", name="by_category")
     */
    public function browseByCategory(Category $category, QuestionRepository $questionRepository, SerializerInterface $serializer)
    {
        if ($category instanceof Category) {

            $questions = $questionRepository->findBy(['category' => $category]);
            $data = $serializer->normalize($questions, 'json', ['groups' => ['question_browse']]);
            return $this->json(['questions' => $data]);

        } else {
            return $this->json(['message' => 'Category not found']);
        }
    }
}

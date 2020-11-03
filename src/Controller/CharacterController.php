<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/profile", name="character_profile")
     */
    public function profile(QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        $user = $this->getUser();
        
        // on cherche a afficher la dernière question ou la dernière réponse de l'utilisateur en affichant la dernière en date
        $lastQuestion = $questionRepository->findUserLastQuestion($user);
        $lastAnswer = $answerRepository->findUserLastAnswer($user);

        if ($lastQuestion && $lastAnswer) {
            if($lastQuestion->getCreatedAt() > $lastAnswer->getCreatedAt()) {
                $lastSubject = $lastQuestion;
            } else {
                $lastSubject = $lastAnswer->getQuestion();
            }
        } else if ($lastQuestion && !$lastAnswer) {
            $lastSubject = $lastQuestion;
        } else if (!$lastQuestion && $lastAnswer) {
            $lastSubject = $lastAnswer->getQuestion();
        } else {
            $lastSubject = null;
        }
            

        $userAnswers = $user->getAnswers();
        $likes = 0;
        foreach($userAnswers as $userAnswer) {
            $likes += count($userAnswer->getLikes());
        }

        
        return $this->render('character/profile.html.twig', [
            'userQuestionsCount' => count($user->getQuestions()),
            'userAnswersCount' => count($user->getAnswers()),
            'lastSubject' => $lastSubject,
            'userTotalLikes' => $likes
        ]);
    }
}

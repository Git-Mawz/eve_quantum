<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Service\EsiClient;
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

        if (isset($lastQuestion[0]) && isset($lastAnswer[0])) {
            if($lastQuestion[0]->getCreatedAt() > $lastAnswer[0]->getCreatedAt()) {
                $lastSubject = $lastQuestion[0];
            } else {
                $lastSubject = $lastAnswer[0]->getQuestion();
            }
        } else if (isset($lastQuestion[0]) && !isset($lastAnswer[0])) {
            $lastSubject = $lastQuestion[0];
        } else if (!isset($lastQuestion[0]) && isset($lastAnswer[0])) {
            $lastSubject = $lastAnswer[0]->getQuestion();
        } else {
            $lastSubject = null;
        }
            
        // dd($lastQuestion, $lastAnswer);

        return $this->render('character/profile.html.twig', [
            'userQuestionsCount' => count($user->getQuestions()),
            'userAnswersCount' => count($user->getAnswers()),
            'lastSubject' => $lastSubject,
        ]);
    }
}

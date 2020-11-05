<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/profile", name="character_profile")
     */
    public function profile(QuestionRepository $questionRepository, AnswerRepository $answerRepository, UserRepository $userRepository)
    {
        $user = $this->getUser();
        
        // TODO make a custom query to get last question or last answer for a given user
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
        
        $userReceivedLikes = $userRepository->findAllReceivedLikes($user);

        return $this->render('character/profile.html.twig', [
            'userQuestionsCount' => count($user->getQuestions()),
            'userAnswersCount' => count($user->getAnswers()),
            'lastSubject' => $lastSubject,
            'userReceivedLikes' => $userReceivedLikes,
            'userGivenLikes' => count($user->getLikes())
        ]);
    }


    /**
     * @Route("/profile/{character_owner_hash}", name="other_character_profile", requirements={"character_owner_hash"=".+"})
     */

    public function otherProfile (User $foreignUser, QuestionRepository $questionRepository, AnswerRepository $answerRepository, UserRepository $userRepository)
    {

        $lastQuestion = $questionRepository->findUserLastQuestion($foreignUser);
        $lastAnswer = $answerRepository->findUserLastAnswer($foreignUser);

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

        $userReceivedLikes = $userRepository->findAllReceivedLikes($foreignUser);

        
        return $this->render('character/other_profile.html.twig', [
            'foreignUser' => $foreignUser,
            'userQuestionsCount' => count($foreignUser->getQuestions()),
            'userAnswersCount' => count($foreignUser->getAnswers()),
            'lastSubject' => $lastSubject,
            'userReceivedLikes' => $userReceivedLikes,
            'userGivenLikes' => count($foreignUser->getLikes())
        ]);
    }
}

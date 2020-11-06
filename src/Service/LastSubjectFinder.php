<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;

class LastSubjectFinder
{
    /**
     * Undocumented function
     *
     * @param User $user
     * @param QuestionRepository $questionRepository
     * @param AnswerRepository $answerRepository
     * @return Question $lastSubject
     */
    public function findUserLastSubject (User $user, QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        // dd($user);
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

        return $lastSubject;
    }
}

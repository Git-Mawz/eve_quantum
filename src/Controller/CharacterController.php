<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use App\Service\LastSubjectFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/profile", name="character_profile")
     */
    public function profile(LastSubjectFinder $lastSubjectFinder, UserRepository $userRepository, AnswerRepository $answerRepository, QuestionRepository $questionRepository)
    {
        $user = $this->getUser();
        
        $lastSubject = $lastSubjectFinder->findUserLastSubject($user, $questionRepository, $answerRepository);
        
        $userReceivedLikes = $userRepository->findAllReceivedLikes($user);
        // patch so request result is turned into an int
        if (count($userReceivedLikes) === 0) {
            $userReceivedLikes = 0;
        } else {
            $userReceivedLikes = $userReceivedLikes[0][1];
        }

        return $this->render('character/profile.html.twig', [
            'userQuestionsCount' => count($user->getQuestions()),
            'userAnswersCount' => count($user->getAnswers()),
            'lastSubject' => $lastSubject,
            'userReceivedLikes' => $userReceivedLikes,
            'userGivenLikes' => count($user->getLikes())
        ]);
    }


    /**
     * @Route("/profile/{character_owner_hash}", name="other_character_profile", requirements={"character_owner_hash"=".*"})
     */

    public function otherProfile (User $foreignUser, LastSubjectFinder $lastSubjectFinder, UserRepository $userRepository, AnswerRepository $answerRepository, QuestionRepository $questionRepository)
    {
        $lastSubject = $lastSubjectFinder->findUserLastSubject($foreignUser, $questionRepository, $answerRepository);

        $userReceivedLikes = $userRepository->findAllReceivedLikes($foreignUser);
        // patch so request result is turned into an int
        if (count($userReceivedLikes) === 0) {
            $userReceivedLikes = 0;
        } else {
            $userReceivedLikes = $userReceivedLikes[0][1];
        }
        
        
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

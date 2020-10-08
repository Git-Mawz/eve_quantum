<?php

namespace App\Service;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

class QuestionSlugger {

    private $slugger;
    private $questionRepository;

    public function __construct(SluggerInterface $slugger, QuestionRepository $questionRepository)
    {   
        $this->slugger = $slugger;
        $this->questionRepository = $questionRepository;
    }
    

    /**
     * Return the slug of a question
     *
     * @param [string] Question Title
     * @return string
     */
    public function sluggifyQuestionTitle($title)
    {   
        $slugToTest = u($this->slugger->slug($title))->lower();
        
        if ($this->slugExistCheck($slugToTest) == true) {
            return u($this->slugger->slug($title . ' ' . random_int(1, 99999999)))->lower();
        } else {
            return u($this->slugger->slug($title))->lower();
        }

    }

    /**
     * return true if the slug exist in database.
     * return false if the slug do not exist
     *
     * @param [string] $slug
     * @return boolean
     */
    public function slugExistCheck($slug)
    {
        if ($this->questionRepository->findOneBy(['slug' => $slug]) instanceof Question) {
            return true;
        } else {
            return false;
        }
    }

}
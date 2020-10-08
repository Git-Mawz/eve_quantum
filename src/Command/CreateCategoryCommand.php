<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateCategoryCommand extends Command
{
    protected static $defaultName = 'create:question-categories';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Create Category for the Eve Quantum Database')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $categories = [
            'Commerce',
            'Compétences',
            'Exploration',
            'Fitting',
            'Industrie',
            'Lore',
            'Minage',
            'PvE',
            'PvP',
            'Wormhole',
        ];


        foreach ($categories as $category) {
            $newCategory = new \App\Entity\Category;
            $newCategory->setName($category);
            $this->em->persist($newCategory);
        }

        $this->em->flush();

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('Question categories have been successfully added to you database');

        return 0;
    }
}

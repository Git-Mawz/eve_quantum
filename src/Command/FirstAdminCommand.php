<?php

namespace App\Command;

use App\Entity\Admin;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FirstAdminCommand extends Command
{
    protected static $defaultName = 'create:first-admin';

    const FIRST_ADMIN_CHARACTER_OWNER_HASH = 'Dr6YVfZhliOGZ5she3PfL0OIv/E=';
    private $em;
    private $userRepository;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Allow to set a first admin to the Eve Quantum application')
            ->addArgument('arg1', InputArgument::REQUIRED, 'Admin username')
            ->addArgument('arg2', InputArgument::REQUIRED, 'Admin password')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $adminUsername = $input->getArgument('arg1');
        $adminPassword = $input->getArgument('arg2');

        // Adding admin role on Krawks for the public site firewall
        $firstAdmin = $this->userRepository->findOneBy(['character_owner_hash' => static::FIRST_ADMIN_CHARACTER_OWNER_HASH]);
        $firstAdmin->setRoles(['ROLE_ADMIN']);

        // Creating the first admin for the dashboard/easyadmin firewall
        $newDashboardAdmin = new Admin();
        $newDashboardAdmin->setUsername($adminUsername);
        $newDashboardAdmin->setPassword($adminPassword);
        $newDashboardAdmin->setRoles(['ROLE_ADMIN']);
        $this->em->persist($newDashboardAdmin);


        // Final flush
        $this->em->flush();


        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('Krawks has been added as the first admin for Eve Quantum');

        return 0;
    }
}

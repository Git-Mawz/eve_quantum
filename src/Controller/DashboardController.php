<?php

namespace App\Controller;

use App\Controller\Admin\QuestionCrudController;
use App\Controller\Admin\UserCrudController;
use App\Entity\Admin;
use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\SolarSystem;
use App\Entity\Suggest;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {   
        // Default Dashboard page with instructions
        // return parent::index();

        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
        }

        return $this->redirect($routeBuilder->setController(QuestionCrudController::class)->generateUrl());


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eve Quantum');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Admin', 'fas fa-user-shield', Admin::class);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Categories', 'fas fa-th-list', Category::class);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Idées', 'far fa-lightbulb', Suggest::class);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Système Solaires', 'fas fa-sun', SolarSystem::class);
        }
        
        yield MenuItem::linkToCrud('Questions', 'fas fa-file-alt', Question::class);
        yield MenuItem::linkToCrud('Réponses', 'far fa-file-alt', Answer::class);

        
    }
}

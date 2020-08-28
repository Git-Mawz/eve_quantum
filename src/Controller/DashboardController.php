<?php

namespace App\Controller;

use App\Controller\Admin\UserCrudController;
use App\Entity\Admin;
use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eve Quantum');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Admin', 'fas fa-user-shield', Admin::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-th-list', Category::class);
        yield MenuItem::linkToCrud('Questions', 'fas fa-file-alt', Question::class);
        yield MenuItem::linkToCrud('Réponses', 'far fa-file-alt', Answer::class);
    }
}

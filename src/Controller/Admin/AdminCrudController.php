<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;

class AdminCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            TextField::new('password')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $addAdmin = Action::new('addAdmin')
            ->linkToRoute('add_admin')
        ;

        return $actions->add(Crud::PAGE_INDEX, $addAdmin);
    }

    // Custom methods
    public function addAdmin(Request $request)
    {
        
    }
   
}


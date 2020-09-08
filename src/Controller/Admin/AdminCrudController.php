<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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

    public function createEntity(string $entityFqcn)
    {
        $newAdmin = new Admin();
        return $newAdmin;
    }
}


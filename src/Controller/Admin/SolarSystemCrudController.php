<?php

namespace App\Controller\Admin;

use App\Entity\SolarSystem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SolarSystemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SolarSystem::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name'),
            IdField::new('universeId'),
            AssociationField::new('user'),
            

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
    return $actions
        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ;
    }
    
}

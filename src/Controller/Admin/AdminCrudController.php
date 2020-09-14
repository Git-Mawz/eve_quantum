<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;
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

    // // Say to easy admin that i will define some actions here
    // public function configureActions(Actions $actions): Actions
    // {
    //     $addAdmin = Action::new('addAdmin')
    //         ->linkToRoute('add_admin')
    //     ;

    //     return $actions->add(Crud::PAGE_INDEX, $addAdmin);
    // }

    // // Customization of the actions (need a route and a route name)

    // /**
    //  * @Route ("/admin/add_admin", name="add_admin")
    //  */

    // public function addAdmin(Request $request)
    // {
        
    //     dd($request);

    // }
   
}


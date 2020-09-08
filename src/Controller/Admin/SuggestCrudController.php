<?php

namespace App\Controller\Admin;

use App\Entity\Suggest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SuggestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Suggest::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

<?php

namespace App\Controller\Admin;

use App\Entity\Suggest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SuggestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Suggest::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('user'),
            TextEditorField::new('content'),
        ];
    }
}

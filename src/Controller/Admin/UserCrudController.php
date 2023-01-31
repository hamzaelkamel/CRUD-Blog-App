<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): crud
    {
       return $crud
              ->setEntityLabelInPlural('User')
              ->setEntityLabelInSingular('User')
              ->setPageTitle("index","EL kamelBG : user administration")
              ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                 ->hideOnForm(),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('email')
                 ->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles'),
            DateTimeField::new('createdAt')
                 ->setFormTypeOption('disabled','disabled')
                 ->hideOnForm(),
        ];
    }
    
}

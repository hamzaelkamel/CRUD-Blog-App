<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): crud
    {
       return $crud
              ->setEntityLabelInPlural('Contacts')
              ->setEntityLabelInSingular('Contact')
              ->setPageTitle("index","EL kamelBG : Contacts administration")
              ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email')
               ->setFormTypeOption('disabled','disabled'),
            TextField::new('subject'),
            TextareaField::new('message'),
                
        ];
    }
    
}

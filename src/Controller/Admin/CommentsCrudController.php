<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CommentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comments::class;
    }

    public function configureCrud(Crud $crud): crud
    {
       return $crud
              ->setEntityLabelInPlural('Comments')
              ->setEntityLabelInSingular('Comment')
              ->setPageTitle("index","EL kamelBG : Comments administration")
              ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                 ->hideOnForm(),
            BooleanField::new('active')
                 ->setFormTypeOption('disabled','disabled'),
            TextField::new('email')
                 ->setFormTypeOption('disabled','disabled'),
            TextField::new('nickname'),
            TextField::new('content'),
            DateTimeField::new('createdAt')
                 ->setFormTypeOption('disabled','disabled')
                 ->hideOnForm(),
            BooleanField::new('rgpd')
                 ->setFormTypeOption('disabled','disabled'),
            
                
        ];
    }
    
}

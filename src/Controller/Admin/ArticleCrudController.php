<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }
     
    public function configureCrud(Crud $crud): crud
    {
       return $crud
              ->setEntityLabelInPlural('Articles')
              ->setEntityLabelInSingular('Article')
              ->setPageTitle("index","EL kamelBG : Articles administration")
              ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                 ->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('content')
                ->hideOnIndex(),
            TextField::new('category'), 
            DateTimeField::new('createdAt')
                 ->setFormTypeOption('disabled','disabled')
                 ->hideOnForm(),
        ];
    }
    
}

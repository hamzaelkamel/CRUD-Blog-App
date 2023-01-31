<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title' ,TextType::class,[
            'attr' => [
                'class' => 'form-control ',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'label' => 'Title',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
           ] )
            ->add('imageFile' , VichImageType::class,[
                'label'=> 'Article Cover Images',
                'label_attr'=> [
                    'class'=>'form-label mt-4'
                ]
            ])
            ->add('Content' , TextareaType::class,[
                'attr' => array('cols' => '10', 'rows' => '10'),
                'attr' => [
                    'class' => 'form-control ',
                    'style'=>'text-align:justify'
                ],
                'label' => ' write the article ',
                'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            ])
            ->add('Category', ChoiceType::class,[
            'choices'  => [
                'Programming' => 'Programming',
                'Health & Medicine' => 'Health & Medicine' ,
                'Humanities' => 'Humanities',
                'Business' => 'Business',
                'Science' => 'Science',
                'Social Sciences' => 'Social Sciences',
            ],
            'attr' => [
                'class' => 'form-control ',
            ],
            'label' => 'choice your Category ',
                'label_attr' => [
                'class' => 'form-label mt-4'
            ],
           ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

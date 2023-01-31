<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstName', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'label' => 'First Name',
            'label_attr' => [
                'class' => 'form_label mt-4'
            ],
        ])
        ->add('lastName',TextType::class,[
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'label' => 'Last Name',
            'label_attr' => [
                'class' => 'form_label mt-4 '
            ],
        ])
        ->add('imageFile' , VichImageType::class,[
            'label'=> 'Image Profil',
            'label_attr'=> [
                'class'=>'form-label mt-4'
            ]
        ])
        ->add('address',TextType::class,[
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '5',
                'maxlenght' => '250',
            ],
            'label' => 'Address',
            'label_attr' => [
                'class' => 'form_label mt-4'
            ],
        ])
        ->add('plainPassword', PasswordType::class,[
            'attr'=>[
                'class' => 'form-control'
            ],
            'label' => 'Password',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])
        ->add('bio', TextType::class,[
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '10',
                'maxlenght' => '500',
            ],
            'label' => 'Bio ',
            'label_attr' => [
                'class' => 'form_label mt-4'
            ],
        ])
        ->add('submit', SubmitType::class,[
            'attr' => [
                'class' => 'btn btn-primary mt-4',
                ]
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

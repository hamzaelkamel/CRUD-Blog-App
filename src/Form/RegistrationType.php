<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control  bg-light',
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
                    'class' => 'form-control bg-light',
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
                    'class' => 'form-control bg-light',
                    'minlenght' => '5',
                    'maxlenght' => '250',
                ],
                'label' => 'Address',
                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
            ])
            ->add('bio', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control ',
                    'rows'=>'8',
                    

                ],
                'label' => 'Bio ',
                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
            ])
            ->add('email' , EmailType::class,[
                'attr' => [
                    'class' => 'form-control bg-light',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Email Address',
                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
            ])
            ->add('plainPassword' , RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control  bg-light',
                    ],
                    'label' => 'Password',
                    'label_attr' => [
                        'class' => 'form_label mt-4'
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control bg-light',
                    ],
                    'label' => 'Password Confirmation',
                    'label_attr' => [
                        'class' => 'form_label mt-4'
                    ],
                ],
                'invalid_message' => 'Password UnConfirmeted !!'
            ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                    ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

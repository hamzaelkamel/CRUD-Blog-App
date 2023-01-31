<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('email' , EmailType::class,[
                'attr' => [
                    'class' => 'form-control w-50 ',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                       
                ],
                'label' => 'email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
               ])
            ->add('Subject',TextType::class,[
                'attr' => [
                    'class' => 'form-control w-50',
                    'minlenght' => '2',
                    'maxlenght' => '100',
                ],
                'label' => 'Subject',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
               ])
            ->add('message',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control w-50',
                    'rows'=>'8',

                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
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
            'data_class' => Contact::class,
        ]);
    }
}

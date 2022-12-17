<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'edit_user' , methods: ['GET','POST'])]
    public function edit(User $user ,Request $request , EntityManagerInterface $manager ,UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser() !== $user){
            return $this->redirectToRoute('app_article');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($user , $form->getData()->getPlainPassword())){
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'The Profil is update with sucssefuly'
                );
    
               
                return $this->redirectToRoute('app_login');
            }else{
                $this->addFlash(
                    'warning',
                    'Password Update Unconformeted '
                );
            }
           
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    
}

#[Route('user/edit_password/{id}', 'app_edit.password' , methods:['GET','POST'])]
public function editPassword(User $user ,Request $request , EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
{ 
    if(!$this->getUser()){
      return $this->redirectToRoute('app_login');
    }
    if($this->getUser() !== $user){
     return $this->redirectToRoute('app_article');
    } 
   $form = $this->createForm(UserPasswordType::class);

   $form->handleRequest($request);
   if ($form->isSubmitted() && $form->isValid()){
       if($hasher->isPasswordValid($user , $form->getData()['plainPassword'])){
           $user->setPassword(
            $hasher->hashPassword(
            $user,
            $form->getData()['newPassword']
           )
        );
           $manager->persist($user);
           $manager->flush();

           $this->addFlash(
               'success',
               'The Password is update with sucssefuly'
           );

          
           return $this->redirectToRoute('app_login');
       }else{
           $this->addFlash(
               'warning',
               'Password Update Unconformeted '
           );
       }}

   return $this->render('user/edit_password.html.twig ',[
    'form' => $form->createView()
   ]);
}
}

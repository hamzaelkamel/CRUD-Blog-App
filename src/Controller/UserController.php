<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'edit_user' , methods: ['GET','POST'])]
    #[Security("is_granted('ROLE_USER') and user === choosenUser")]
    public function edit(User $choosenUser ,Request $request , EntityManagerInterface $manager ,UserPasswordHasherInterface $hasher): Response
    {
       
        $form = $this->createForm(UserType::class, $choosenUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($choosenUser , $form->getData()->getPlainPassword())){
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


#[Route('user/editPassword/{id}', 'app_edit.password' , methods:['GET','POST'])]
#[Security("is_granted('ROLE_USER') and user === choosenUser")]
public function editPassword(User $choosenUser ,Request $request , EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
{ 
   
   $form = $this->createForm(UserPasswordType::class);

   $form->handleRequest($request);
   if ($form->isSubmitted() && $form->isValid()){
       if($hasher->isPasswordValid($choosenUser , $form->getData()['plainPassword'])){
        $choosenUser->setPassword(
            $hasher->hashPassword(
             $choosenUser,
            $form->getData()['newPassword']
           )
        );
           $manager->persist($choosenUser);
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

   return $this->render('user/editPassword.html.twig' , [
    'form' => $form->createView()
   ]);
}

#[Security("is_granted('ROLE_USER') ")]
#[Route('user/delete/{id}','user_delete', methods: ['GET'])]
public function delete(EntityManagerInterface $manager, User $user ): Response
{
   if(!$user){
    $this->addFlash(
        'success',
        'The User is Deleted With Success !'
    );
    return $this->redirectToRoute('app_article');
   }
   $manager->remove($user);
   $manager->flush();
   $this->addFlash(
    'success',
    'The user is Deleted '
   );
    return $this->redirectToRoute('app_home');
}

#[Security("is_granted('ROLE_USER') ")]
#[Route('user/account/', 'app_account' , methods:['GET','POST'])]
public function account( Request $request, EntityManagerInterface $manager): Response
{
    
    return $this->render('user/account.html.twig', [
        'controller_name' => 'UserController',
    ]);
}


}

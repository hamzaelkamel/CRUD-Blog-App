<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET','POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            
        ]);
       
           
          
    }

    #[Route('logout', 'app_logout')]
    public function logout()
    {
      // Nothing to do
    }
    
    #[Route('/registration', 'app_registration', methods:['GET','POST'])]
    public function registration( Request $request , EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);
         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
 
            $this->addFlash(
                'success',
                'The Compte is craete with sucssefuly'
            );

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');

        }
      
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);

    }
}

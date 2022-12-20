<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleController extends AbstractController
{
     #[Route('/article', name: 'app_article')]
     #[IsGranted('ROLE_USER')]
    public function index(ArticleRepository $repository): Response
    {         
        return $this->render('article/index.html.twig', [
            'articles' =>$repository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/article/new','article.new',methods:['GET','POST'])]
    #[IsGranted('ROLE_USER')]
    public function new( Request $request, EntityManagerInterface $manager): Response
    {
        $article = new article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            $article->setUser($this->getUser());
            
            $manager->persist($article);
            $manager->flush();
           
            $this->addFlash(
                'success',
                'The Article is Add With Success !'
            );
            return $this->redirectToRoute('app_article');
        }
         return $this->render('article/new.html.twig', [
            'form'=> $form->createView()
         ]);
    }

    
   #[Route('article/edit/{id}','article_edit', methods: ['GET','POST'])]
   #[Security("is_granted('ROLE_USER') and user === article.getUser()")]
   public function edit( Article $article , Request $request, EntityManagerInterface $manager ): Response
   {
   
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $article = $form->getData();
        
        $manager->persist($article);
        $manager->flush();
       
        $this->addFlash(
            'success',
            'The Article is Modify With Success !'
        );
        return $this->redirectToRoute('app_article');

    }
     return $this->render('article/edit.html.twig' , [
        'form' => $form->createView()
     ]);
    }

    #[Route('article/delete/{id}','article_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Article $article ): Response
    {
       if(!$article){
        $this->addFlash(
            'success',
            'The Article is Deleted With Success !'
        );
        return $this->redirectToRoute('app_article');
       }
       $manager->remove($article);
       $manager->flush();
       $this->addFlash(
        'success',
        'The Article is Deleted With Success !'
       );
        return $this->redirectToRoute('app_article');
    }
}

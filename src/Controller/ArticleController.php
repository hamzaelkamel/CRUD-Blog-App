<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\Article;
use App\Entity\Comments;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Form\CommentsType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{
     #[IsGranted('ROLE_USER')]
     #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $repository , PaginatorInterface $paginator , Request $request): Response
    {    
        $articles = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser() ]),
            $request->query->getInt('page',1),
            10

        );
        return $this->render('article/index.html.twig', [
            'articles' => $articles
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

    #[Route('/article/details/{id}', name: 'articles_details', methods: ['GET','POST'])]
    public function details(Article   $article  ,Request $request,ManagerRegistry $doctrine, EntityManagerInterface $manager): Response
    {
          $comment = new Comments;
          $commentForm = $this->createForm(commentsType::class, $comment);
          $commentForm->handleRequest($request);
          if($commentForm->isSubmitted() && $commentForm->isValid()){
              $comment->setCreatedAt(new DateTime());
              $comment->setArticles($article);
              $manager = $doctrine->getManager();
              $manager->persist($comment);
              $manager->flush();
              $this->addFlash(
               'success',
               'The Comment is add with success');
               return $this->redirectToRoute('articles_details', ['id'=>$article->getId()]);
          }
       return $this->render('home/details.html.twig'  , [
        'article' => $article,
        'commentForm'=> $commentForm->createView()
       ]) ;
    }
    
}

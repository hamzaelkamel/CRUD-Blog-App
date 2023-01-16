<?php

namespace App\Controller;

use App\Controller\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;
use App\Data\SearchData;
use App\Form\SearchForm;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function index(ArticleRepository $repository ): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' =>$repository->findBy(['user' => $this->getUser() ]),
        ]);
    }

 /** @var User $user */
#[Route('show_articles' , name: 'app_show_articles')]
public function showArticle(ArticleRepository $repository , UserRepository $repo , PaginatorInterface $paginator , Request $request): Response
{   
   $data = new SearchData();
   $form = $this->createForm(SearchForm::class,$data);
   $form->handleRequest($request);
   $articles = $paginator->paginate(
   $repository->findSearch($data),
   $request->query->getInt('page',1),
   10);
   
    return $this->render('home/show_article.html.twig', [
           'articles' =>$articles,
           'form'=>$form->createView()
    ]);
}




 
   
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchArticleController extends AbstractController
{
    #[Route('/search/article', name: 'app_search_article')]
    public function searchCar(Request $request): Response
    {
        return $this->render('search_article/searcharticle.html.twig', [
            'controller_name' => 'SearchArticleController',
        ]);
    }
}

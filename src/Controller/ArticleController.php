<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_list')]
    public function articles(ArticleRepository $articleRepository): Response
    {
       $articles = $articleRepository->findAll();

        return $this->render('articles_list.html.twig', ['articles' => $articles]);
    }

    // Creating the URL for my new page about article, this URL got a var right now as id
    #[Route('/article/{id}', 'article_show', ['id' => '\d+'], ['id' => 1])]
    // function got a new parameter, this one match with url var name. Symfony put URL var as parameter of the function
    public function showArticle(int $id, ArticleRepository $articleRespository): Response
    {
        $articleFound = $articleRespository->find($id);

        if (!$articleFound) {
            return $this->redirectToRoute('not_found');
        }
// I do a return an HTTP answer thanks to render method
        return $this->render('article_show.html.twig',
            ['article' => $articleFound]);
    }

    #[Route('articles/search-results', name: 'article_search_results')]
    // instead of using createFromGlobal and create a new var $request using it, I put as parameter of the function the class type and the var associated, it's called autowire
    public function articleSearchResults(Request $request)
    {

        $search = $request->query->get('search');

        return $this->render('article_search_results.html.twig', ['search' => $search]);

    }
}
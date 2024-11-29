<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('article/create', 'article_create')]
    public function createArticle(Request $request, EntityManagerInterface $entityManager)
    {
// Creating a new Article
            $article = new Article();
            // I use AbstractController'method to gen a from for the new article
        //I put as parameter the way for the class's model and as second parameter my fresh var created
        $form = $this->createForm(ArticleType::class, $article);
// I get data from request
        $form->handleRequest($request);
        // If form is submitted
        if ($form->isSubmitted()) {
            // I auto edit creation date
            $article->setCreatedAt(new \DateTime());
            // Pre save data
            $entityManager->persist($article);
            // Register in database
            $entityManager->flush();
        }
        // I create now a view for this form to use it in the twig
        $formView = $form->createView();

        return $this->render('article_create.html.twig', ['formView' => $formView]);


    }
    #[Route('/article/delete/{id}', 'delete_article', ['id' => '\d+'] )]
    // Here I get the id from URL, I also call the entity manager to use his methods, and I call the arti.repo to find it in database
    public function removeArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response {

        //Select article by id thanks to art repo
        $article = $articleRepository->find($id);
        // If article not found (already deleted for example, we return an error (here Error 404, but we ca, create a new Route to explain this article doesn't exist
        if (!$article) {
            return $this->redirectToRoute('not_found');
        }
        // Delete article and presave thanks to remove method from entityManager
        $entityManager->remove($article);
        // Register remove in database
        $entityManager->flush();

        return $this->render('article_delete.html.twig', ['article' => $article]);
    }
    #[Route('/article/update/{id}', 'update_article', ['id' => '\d+'])]
public function updateArticle(int $id, Request $request, EntityManagerInterface $entityManager, ArticleRepository $articleRepository) {
        // I get the article in the repo by the ID mentionned in the URL
        $article = $articleRepository->find($id);
        // I set a message to explain what we are waiting from user
        // I use AbstractController'method to gen a from to update article
        //I put as parameter the way for the class's model and as second parameter my fresh var created
        $form = $this->createForm(ArticleType::class, $article);
// I get data from request
        $form->handleRequest($request);
        // If form is submitted
        if ($form->isSubmitted()) {
            // Pre save data
            $entityManager->persist($article);
            // Register in database
            $entityManager->flush();
        }
        // I update now a view for this form to use it in the twig
        $formView = $form->createView();

        return $this->render('article_update.html.twig', ['formView' => $formView]);
    }
}
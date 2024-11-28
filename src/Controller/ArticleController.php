<?php

namespace App\Controller;

use App\Entity\Article;
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


        if ($request->isMethod('POST')) {

            // Create an article
            $article = new Article();
            // Using set methods to fill article's proprieties
            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');
            if (empty($title) || empty($content)) {

                return $this->render("contact.html.twig", [
                    'error' => 'Veuillez remplir tous les champs',
                    'title' => $title,
                    'content' => $content,
                ]);
            }

            $article->setTitle($title);
            $article->setContent($content);
            $article->setImage($image);
            $article->setCreatedAt(new \DateTime('now'));


            // Register it thanks to entityManager
            // This ons allows to save and delete entities in database
            // persist can pre-save entities
            $entityManager->persist($article);
            // flush execute SQL's request to create a new article
            $entityManager->flush();

            return $this->render('article_create.html.twig', ['article' => $article]);

        } else {
            $view = $this->renderView('404.html.twig');
        }
        return $this->render("article_create.html.twig");

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
public function updateArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository) {
        // I get the article in the repo by the ID mentionned in the URL
        $article = $articleRepository->find($id);
        // I edit the title and de content of the article
        $article->setTitle('Article 5 v1.1');
        $article->setContent("C'est le contenu de l'article 5 v1.1");
        // I presave my modification in database
        $entityManager->persist($article);
        // flush execute SQL's request to update the article
        $entityManager->flush();

        return $this->render('article_update.html.twig', ['article' => $article]);

    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_list')]
    public function articles()
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Power Ranger Bleu',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'blue'
            ],
            [
                'id' => 2,
                'title' => 'Power Ranger Rouge',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'red'
            ],
            [
                'id' => 3,
                'title' => 'Power Ranger Jaune',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'yellow'
            ],
            [
                'id' => 4,
                'title' => 'Power Ranger Rose',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'pink'
            ],
            [
                'id' => 5,
                'title' => 'Power Ranger Vert',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'green'
            ]

        ];

        return $this->render('articles_list.html.twig', ['articles' => $articles]);
    }

    // Creating the URL for my new page about article, this URL got a var right now as id
    #[Route('/article/{id}', 'article_show')]
    // function got a new parameter, this one match with url var name. Symfony put URL var as parameter of the function
    public function showArticle($id)
    {

        $articles = [
            [
                'id' => 1,
                'title' => 'Power Ranger Bleu',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'blue'
            ],
            [
                'id' => 2,
                'title' => 'Power Ranger Rouge',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'red'
            ],
            [
                'id' => 3,
                'title' => 'Power Ranger Jaune',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'yellow'
            ],
            [
                'id' => 4,
                'title' => 'Power Ranger Rose',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'pink'
            ],
            [
                'id' => 5,
                'title' => 'Power Ranger Vert',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'color' => 'green'
            ]

        ];
// I create my new var $article as null for now
        $article = null;

        // for each articles in the array I check if his ad match with id from get method, if yes articleFound become the article with the id
        foreach ($articles as $article) {
            if ($article['id'] === (int)$id) {
                $articleFound = $article;
            }
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
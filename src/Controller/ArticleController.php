<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
#[Route('/article', name: 'articles_list')]
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
}
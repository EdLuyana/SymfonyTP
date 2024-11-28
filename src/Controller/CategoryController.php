<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Class is using AbstractController proprieties

class CategoryController extends AbstractController
{
    // Creating the URL
    #[Route('/categories-all', 'categories_all')]
    // Function is calling a new CategoryRepo and put it in a new var $categoryRepository
    public function categoriesAll(CategoryRepository $categoryRepository): Response
{
// var categories get all the $categoryRepo thanks to findAll
    $categories = $categoryRepository->findAll();

    // $categories become the var 'categories' in the twig and thanks to render the return is mandatory code 200
    return $this->render('categories_list.html.twig', ['categories' => $categories]);

}

// Creating the URL, I added a var in this one, this var is manda an INTEGER and put as '1' by default
#[Route('/category/{id}', 'category_show', ['id' => '\d+'], ['id' => 1])]
// Same as previously except, the var fom the URL is linked to the first parameter in the function
public function categoryShow(int $id, CategoryRepository $categoryRepository): Response
{
    // Instead of getting all infos from $cateRepo, we will just find the id matchin
    $categoryFound = $categoryRepository->find($id);

    // if it doesn't match with any idea, error 404

    if (!$categoryFound) {
        return $this->redirectToRoute('not_found');
    }
    // cetegoryFound become 'category' var in the twig
    return $this->render('category_show.html.twig', ['category' => $categoryFound]);
}
}
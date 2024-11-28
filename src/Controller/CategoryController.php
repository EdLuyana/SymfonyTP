<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/category/create', name: 'category_create')]

    //Here we call EntityManagerInterface to be able to use it, and we create a var to manage entities
    public function createCategory(EntityManagerInterface $entityManager){

        // Create an article

        $category = new Category();

        // Using set methods to fill category's proprieties
        $category->setTitle('Animals');
        $category->setColor('orange');

        // Register it thanks to entityManager
        // This ons allows to save and delete entities in database
        // persist can pre-save entities
        $entityManager->persist($category);
        // flush execute SQL's request to create a new article
        $entityManager->flush();

        return $this->render('category_create.html.twig', ['category' => $category]);


    }
}
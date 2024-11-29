<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function createCategory(Request $request, EntityManagerInterface $entityManager)
    {
            $category = new Category();
        // I use AbstractController's method to gen a from for the new category
        //I put as parameter the way for the class's model and as second parameter my fresh var created
        $form = $this->createForm(CategoryType::class, $category);
// I get data from request
        $form->handleRequest($request);
        // If form is submitted
        if ($form->isSubmitted()) {
            // Pre save data
            $entityManager->persist($category);
            // Register in database
            $entityManager->flush();
        }
        // I create now a view for this form to use it in the twig
        $formView = $form->createView();

        return $this->render('category_create.html.twig', ['formView' => $formView]);

    }

    #[Route('/category/delete/{id}', 'delete_category', ['id' => '\d+'])]
    // Here I get the id from URL, I also call the entity manager to use his methods, and I call the cate.repo to find it in database
    public function removeCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {

        //Select category by id thanks to art repo
        $category = $categoryRepository->find($id);
        // If category not found (already deleted for example, we return an error (here Error 404, but we ca, create a new Route to explain this category doesn't exist
        if (!$category) {
            return $this->redirectToRoute('not_found');
        }
        // Delete category and presave thanks to remove method from entityManager
        $entityManager->remove($category);
        // Register remove in database
        $entityManager->flush();

        return $this->render('category_delete.html.twig', ['category' => $category]);
    }
    #[Route('/category/update/{id}', 'update_category', ['id' => '\d+'])]
    public function updateCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, Request $request): Response {
        // I get the category in the repo by the ID mentioned in the URL
        $category = $categoryRepository->find($id);
        $message = "Merci de remplir les champs";
        if ($request->isMethod('POST')) {

            // Using set methods to fill category's proprieties
            $title = $request->request->get('title');
            $color = $request->request->get('color');

            $category->setTitle($title);
            $category->setColor($color);
            // Register it thanks to entityManager
            // This ons allows to save and delete entities in database
            // persist can pre-save entities
            $entityManager->persist($category);
            // flush execute SQL's request to create a new category
            $entityManager->flush();

            $message = "Categorie '" . $category->getTitle() . "' a bien été modifiée";


        }
        return $this->render("category_update.html.twig", ['category' => $category, 'message' => $message]);


    }
}
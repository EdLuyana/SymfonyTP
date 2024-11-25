<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Creating new class: HomeController
class HomeController{
    // Adding the access, '/' become the function above
    #[Route('/', 'home')]
    //I create the method "home"
public function home(){
        // This method return a new Response
        return new Response('<h1>Page Accueil</h1>');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Creating new class Poker
class PokerController extends AbstractController
{
    //Giving the URL access to the function above
    #[Route('/poker', name: 'poker')]
//Creating a new method 'poker'
    public function poker()
    {
        // Calling and creating a new createFromGlobals w/o using "new"
        // This one fills $request with all datas from GET, POST, SESSION, etc...
        $request = Request::createFromGlobals();
        //I use query to get all my datas
        $age = $request->query->get('age');
        //var_dump($age); die;
        //return new Response('Bienvenue sur le site de Poker');
        if ($age < 18) {
            return $this->render('Poker/pokerEnfant.html.twig');
        }
        return $this->render('Poker/poker.html.twig');

    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
// I create the URL
    #[Route('/contact', 'contact')]

    // Here the function to show the message with a request method
    public function showMessage(Request $request)
    {
// Since I use post method in th form, I need to use request instead of query to get infos from the from
        $contactName = $request->request->get('contactName');
        $message = $request->request->get('message');

        // I return to the twig file my vars as 'nom' and 'message'

        return $this->render("contact.html.twig", ['nom'=>$contactName, 'message'=>$message]);


    }


}
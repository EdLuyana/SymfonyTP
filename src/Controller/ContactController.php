<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    #[Route('/contact', 'contact')]
    public function showMessage(Request $request)
    {

        $contactName = $request->request->get('contactName');
        $message = $request->request->get('message');

        // return new Response("Nom $contactName, Message: $message");

        return $this->render("contact.html.twig", ['nom'=>$contactName, 'message'=>$message]);


    }


}
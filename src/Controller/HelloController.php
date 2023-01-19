<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'app_hello_afficher')]

    public function afficher(Request $request): Response
    {//récupère la valeur de la clé name du array GET , ou affiche par défault
        $name = $request->query->get('name', 'default_name');

        return new Response(sprintf('Hello %s !', $name));
    }
}

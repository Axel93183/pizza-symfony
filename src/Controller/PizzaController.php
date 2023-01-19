<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    

    #[Route('/pizza/generate', name: 'app_pizza_generate')]

        //Méthode avec en paramètre ( ClasseRepository, $objetRepository) qui retourne un $objet de la Classe Response

        public function generate(PizzaRepository $pizzaRepository) : Response{

        // - 1 - CRÉATION DE L'OBJET D'UNE ENTITÉ : Instanciation d'un objet de la classe Pizza dans App\Entity\Pizza

        $pizza= new Pizza;
        $pizza->setName('Calzone');
        $pizza->setPrice(13.90);

        // - 2 - Appel de la methode de la classe PizzaRepository; ICI save();

        $pizzaRepository->save($pizza , true);

        return new Response("La pizza avec l'id {$pizza->getId()} a bien été générée dans la base de données !!!");
    }

        //#[Route('/pizza', name: 'app_pizza_newPizza')]

        //public function newPizza(PizzaRepository $pizzaRepository): Response
        //{
        //$pizza= new Pizza;
        //$pizza->setName('Margarita');
        //$pizza->setPrice(9.90);

        //$pizzaRepository->save($pizza , true);

        //return new Response("La pizza avec l'id {$pizza->getId()} a bien été enregistré !!!");
        // }


        // #[Route('/pizza/{id}/show', name: 'app_pizza_show')]

        // public function show(Pizza $pizza) : Response{

        //     return new Response (sprintf("La pizza {$pizza->getName()}" ));
        // }

        #[Route('/pizza/list', name: 'app_pizza_list')]

        public function list(PizzaRepository $pizzaRepository) : Response
        {
           $list = $pizzaRepository->findAll();
            
        // Retourne une instance de Response avec le contenue html de notre template
            return $this->render('pizza/list.html.twig', 
            
        // Définie les variables accessible dans notre template twig        
            ['list' => $list]);

        }

        #[Route('/pizza/nouvelle', name: 'app_pizza_')]
        public function nouvelle(Request $request, PizzaRepository $pizzaRepository){

            if($request->isMethod('POST')){

                $name= $request->request->get('name');
                $price= $request->request->get('price');
                $description= $request->request->get('description');
                $imageUrl= $request->request->get('imageUrl');

                $pizza = new Pizza;
                $pizza->setName($name);
                $pizza->setPrice($price);
                $pizza->setDescription($description);
                $pizza->setImageUrl($imageUrl);

                $pizzaRepository->save($pizza, true);

                return $this->redirectToRoute('app_pizza_list');
            }
            return $this->render('pizza/newPizza.html.twig');
        }

}
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

    public function generate(PizzaRepository $pizzaRepository): Response
    {
        // - 1 - CRÉATION DE L'OBJET D'UNE ENTITÉ : Instanciation d'un objet de la classe Pizza dans App\Entity\Pizza

        $pizza= new Pizza();
        $pizza->setName('Calzone');
        $pizza->setPrice(13.90);

        // - 2 - Appel de la methode de la classe PizzaRepository; ICI save();

        $pizzaRepository->save($pizza, true);

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

    public function list(PizzaRepository $pizzaRepository): Response
    {//recuperer la liste des pizza depuis la base de données
        $list = $pizzaRepository->findAll();//retourne une liste d'objets pizza

        // Retourne une instance de Response avec le contenue html de notre template
        return $this->render(
            'pizza/list.html.twig',

            // Définie les variables accessible dans notre template twig
            ['list' => $list]
        );
    }

    #[Route('/pizza/nouvelle', name: 'app_pizza_nouvelle')]
    public function nouvelle(Request $request, PizzaRepository $pizzaRepository)
    {
        if ($request->isMethod('POST')) {
            $name= $request->request->get('name');
            $price= $request->request->get('price');
            $description= $request->request->get('description');
            $imageUrl= $request->request->get('imageUrl');

            $pizza = new Pizza();
            $pizza->setName($name);
            $pizza->setPrice($price);
            $pizza->setDescription($description);
            $pizza->setImageUrl($imageUrl);

            $pizzaRepository->save($pizza, true);

            return $this->redirectToRoute('app_pizza_list');
        }
        return $this->render('pizza/newPizza.html.twig');
    }

    #[Route('/pizza/{id}/modifier', name: 'app_pizza_update')]

    public function update(int $id, Request $request, PizzaRepository $pizzaRepository): Response
    {
        //recuperer la pizza qu 'on va modifier avec l'id reçu dans la base de données ('Repository')
        $pizza= $pizzaRepository->find($id);

        // 1. Tester si le formulaire à été envoyé
        if ($request->isMethod('POST')) {
            // 2. Récupérer les données du formulaire
            $name= $request->request->get('name');
            $price= $request->request->get('price');
            $description= $request->request->get('description');
            $imageUrl= $request->request->get('imageUrl');

            // 3. Modifier la pizza avec les données du formulaire
            $pizza->setName($name);
            $pizza->setPrice($price);
            $pizza->setDescription($description);
            $pizza->setImageUrl($imageUrl);

        // 4. Utiliser le repository afin d'enregistrer la pizza en base de données
            $pizzaRepository->save($pizza, true);// le true permet de mettre à jour la base de données directement

            // 5. Si tout c'est bien passé, rediriger vers la liste des pizzas
            return $this->redirectToRoute('app_pizza_list');
        }


        return $this->render('pizza/updatePizza.html.twig', ['pizza'=> $pizza,]);
    }
    
    #[Route('/pizza/{id}/supprimer', name: 'app_pizza_remove')]
    public function remove(int $id, PizzaRepository $repository): Response
    {
        //récuperer le pizza depuis la base de données
        $pizza= $repository->find($id);

        //je supprime la pizza
        $repository->remove($pizza, true);

        //redirection vers la liste des pizzas
        return $this->redirectToRoute('app_pizza_list');
    }
}
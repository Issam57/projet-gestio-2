<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * Permet d'afficher la liste de tous les restaurants
     *
     * @Route("/restos", name="restos_index")
     */
    public function index(RestaurantRepository $repo)
    {
        $restos = $repo->findAll();


        return $this->render('restaurant/index.html.twig', [
            'restos' => $restos
        ]);
    }

    /**
     * Permet d'afficher un seul restaurant
     *
     * @Route("/restos/{slug}", name="restos_show")
     *
     * @return Response
     */
    public function show(Restaurant $rest) {

        return $this->render('restaurant/show.html.twig', [
            'rest' => $rest
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilClientController extends AbstractController
{
    /**
     * @Route("/accueil/client", name="accueil_client")
     */
    public function accueil(NewsRepository $newsRepo, RestaurantRepository $restoRepo)
    {
        $news = $newsRepo->findAll();
        $restos = $restoRepo->findAll();

        return $this->render('accueil_client/accueil.html.twig', [
            'news' => $news,
            'restos' => $restos
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * Permet de récupérer les plats et de les afficher sur la page Commande
     * 
     * @Route("/commande", name="commande")
     */
    public function index(PlatRepository $platRepository)
    {
        return $this->render('commande/index.html.twig', [
            'plats' => $platRepository->findAll()
        ]);
    }
}

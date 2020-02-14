<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(PlatRepository $platRepository)
    {
        return $this->render('commande/index.html.twig', [
            'plats' => $platRepository->findAll()
        ]);
    }
}

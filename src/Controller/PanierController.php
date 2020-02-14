<?php

namespace App\Controller;

use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * Liste des plats
     *
     * @Route("/panier", name="panier_index")
     */
    public function index(PanierService $panierService)
    {
        return $this->render('panier/index.html.twig', [
            'items' => $panierService->getFullCart(),
            'total' => $panierService->getTotal()
        ]);
    }

    /**
     * Ajouter un plat au panier
     *
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, PanierService $panierService) {

        $panierService->add($id);

        return $this->redirectToRoute("panier_index");

    }

    /**
     * Supprimer un plat du panier
     *
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, PanierService $panierService) {

        $panierService->remove($id);

        return $this->redirectToRoute("panier_index");
    }
}

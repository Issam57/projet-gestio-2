<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilClientController extends AbstractController
{
    /**
     * @Route("/accueil/client", name="accueil_client")
     */
    public function accueil()
    {
        return $this->render('accueil_client/accueil.html.twig');
    }
}

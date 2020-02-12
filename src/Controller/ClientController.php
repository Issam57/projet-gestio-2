<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client/{slug}", name="client_show")
     */
    public function index(Client $client)
    {
        return $this->render('client/index.html.twig', [
            'client' => $client
        ]);
    }
}

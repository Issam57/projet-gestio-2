<?php

namespace App\Service\Panier;


use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    protected $session;
    protected $platRepository;

    public function __construct(SessionInterface $session, PlatRepository $platRepository)
    {
        $this->session = $session;
        $this->platRepository = $platRepository;
    }

    public function add(int $id) {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart() : array {

        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'plat' => $this->platRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierWithData;
    }

    public function getTotal() : float {

        $total = 0;

        foreach($this->getFullCart() as $item) {

            $total += $item['plat']->getPrix() * $item['quantity'];
        }

        return $total;
    }
}
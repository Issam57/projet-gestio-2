<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminNewsController extends AbstractController
{
    /**
     * @Route("/admin/news", name="admin_news")
     */
    public function index(NewsRepository $newsRepo)
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $newsRepo->findAll()
        ]);
    }
}

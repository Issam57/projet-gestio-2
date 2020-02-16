<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news_index")
     */
    public function index(NewsRepository $repo)
    {

        $news = $repo->findAll();

        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }
}

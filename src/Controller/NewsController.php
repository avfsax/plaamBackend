<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/news', name: 'app_i_place')]
class NewsController extends AbstractController
{
    #[Route('/list', name: 'api_news_list')]
    public function listNews(ManagerRegistry $doctrine): JsonResponse
    {

        $news = $doctrine->getRepository(News::class)->findAll();

        return $this->json([
            'news' => $news
        ]);
    }

    #[Route('/{id}', name: 'api_news_one')]
    public function oneNews(News $news, ManagerRegistry $doctrine): JsonResponse
    {
        return $this->json([
            'news' => $news
        ]);
    }

}

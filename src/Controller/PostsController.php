<?php

namespace App\Controller;

use App\Entity\Posts;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

#[Route('/api/posts', name: 'app_posts')]
class PostsController extends AbstractController
{

    #[Route('/list', name: 'api_posts_list')]
    public function listNews(ManagerRegistry $doctrine): JsonResponse
    {

        $posts = $doctrine->getRepository(Posts::class)->findAll();

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('detail')
            ->toArray();

        return $this->json([
                'posts' => $posts
            ],200,[], $context);
    }

    #[Route('/{id}', name: 'api_post_one')]
    public function oneNews(Posts $post, ManagerRegistry $doctrine): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('detail')
            ->toArray();

        return $this->json([
            'post' => $post
        ],200,[], $context);
    }

}

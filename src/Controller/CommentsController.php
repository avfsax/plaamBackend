<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

#[Route('/api/comments', name: 'app_comments')]
class CommentsController extends AbstractController
{


    #[Route('/{id}', name: 'api_create_comment')]
    public function onePost(Posts $post, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, Security $security): JsonResponse
    {
        $data = $request->toArray();
        $msg = $data["msg"];

        $comment = new Comments();
        $comment->setMessage($msg);
        $comment->setAuthor($security->getUser());
        $comment->setPosts($post);

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->json([
            'result' => 'OK',
            'comment' => $comment
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

class UserDataController extends AbstractController
{
    #[Route('/api/findUser/', name: 'app_user_data')]
    public function index(Security $security): JsonResponse
    {

        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups('detail')
            ->toArray();

        return $this->json([
            'user' => $security->getUser()
        ],200,[], $context);
    }
}

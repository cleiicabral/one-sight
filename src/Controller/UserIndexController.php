<?php

namespace App\Controller;

use App\Service\User\UserIndexService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserIndexController extends AbstractController
{
    #[Route('/user/index', name: 'user_list', methods:['GET'])]
    public function index(UserIndexService $userIndexService, SerializerInterface $serializer): JsonResponse
    {
        try {
            $serializedUser = $serializer->serialize( $userIndexService->execute(), 'json' );
            return new JsonResponse( $serializedUser, 200, [], true );
        } catch (\Throwable $th) {
            return $this->json([
                'error' => $th->getMessage()
            ]);
        }

    }

}

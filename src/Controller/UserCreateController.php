<?php

namespace App\Controller;

use App\Dto\UserCreateDto;
use App\Repository\UserRepository;
use App\Service\User\UserCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserCreateController extends AbstractController
{
    #[Route('/user/create', name: 'user_create', methods: ['POST'])]
    public function create(Request $request, UserCreateService $userCreateService, SerializerInterface $serializer): JsonResponse
    {
        try {
            $userDto = new UserCreateDto($request->request->all());
            $userCreated = $userCreateService->execute($userDto);
            $serializedUser = $serializer->serialize($userCreated, 'json');
    
            return new JsonResponse($serializedUser, 200, [], true);
        } catch (\Throwable $th) {
            return $this->json([
                'error' => $th->getMessage()
            ]);
        }


    }
}

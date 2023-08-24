<?php

namespace App\Controller;

use App\Dto\UserCreateDto;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserCreateController extends AbstractController
{
    #[Route('/user/create', name: 'user_create', methods: ['POST'])]
    public function create(Request $request, UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {

        $userDto = new UserCreateDto($request->request->all());
        $userDto->password = hash("md5",$userDto->password);
        $userCreated = $userRepository->create($userDto);
        
        $serializedUser = $serializer->serialize($userCreated, 'json');

        return new JsonResponse($serializedUser, 200, [], true);
    }
}

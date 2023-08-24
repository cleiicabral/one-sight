<?php

namespace App\Controller;

use App\Dto\UserLoginDto;
use App\Service\Auth\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ["POST"])]
    public function index(Request $request, LoginService $loginService): JsonResponse
    {
        try {

            $userDto = new UserLoginDto($request->request->all());
            $user = $loginService->execute($userDto);

            return $this->json([
                'authenticated' => $user ? true : false,
                'name' => $user ? $user->getName() : null
            ]);

        } catch (\Throwable $th) {

            return $this->json([
                'error' => $th->getMessage()
            ]);

        }
        
    }
}

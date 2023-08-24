<?php

namespace App\Service\Auth;

use App\Dto\UserLoginDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;

class LoginService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserLoginDto $userLoginDto): User
    {
        $user = $this->userRepository->findByEmail($userLoginDto->email);

        if(!$user){
            throw new Exception("Email ou senha incorretos", 401);   
        }

        if(!password_verify($userLoginDto->password,$user->getPassword())){
            throw new Exception("Email ou senha incorretos", 401);
        }

        return $user;

    }
}
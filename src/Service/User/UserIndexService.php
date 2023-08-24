<?php

namespace App\Service\User;

use App\Repository\UserRepository;
use Exception;

class UserIndexService {
    
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        $users = $this->userRepository->index();

        if(!$users){
            throw new Exception("Usuários não encontrados");
        }

        return $users;
    }
}
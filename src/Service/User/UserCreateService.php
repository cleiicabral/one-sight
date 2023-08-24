<?php

namespace App\Service\User;

use App\Dto\UserCreateDto;
use App\Repository\UserRepository;
use Error;

class UserCreateService {

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserCreateDto $userDto)
    {
        $findUser = $this->userRepository->findByEmail($userDto->email);

        if($findUser){
            throw new Error("Usuário já existe com este e-mail, tente utilizar outro e-mail");
        }    
        $userDto->password = hash("md5",$userDto->password);

        $userCreated = $this->userRepository->create($userDto);

        return $userCreated;
    }
}
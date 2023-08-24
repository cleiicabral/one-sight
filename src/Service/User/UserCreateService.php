<?php

namespace App\Service\User;

use App\Dto\UserCreateDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserCreateService {

    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function execute(UserCreateDto $userDto)
    {
        $this->entityManager->beginTransaction();
        try {
            $findUser = $this->userRepository->findByEmail($userDto->email);
        
            if($findUser){
                throw new Exception("Usuário já existe com este e-mail, tente utilizar outro e-mail");
            }    
            $userDto->password = password_hash($userDto->password, getenv("HASH_PASSWORD"));
    
            $userCreated = $this->userRepository->create($userDto);
            $this->entityManager->commit();

            return $userCreated;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception('Erro ao criar usuário: ' . $e->getMessage());
        }

    }
}
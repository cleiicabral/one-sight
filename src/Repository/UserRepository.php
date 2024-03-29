<?php

namespace App\Repository;

use App\Dto\UserCreateDto;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(UserCreateDto $userDto, ): User
    {
        try {
            $user = new User();
            $user->setName($userDto->name);
            $user->setEmail($userDto->email);
            $user->setPassword($userDto->password);
            $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
    
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            
            $userFind = $this->findOneBySomeField($user->getId());

            return $userFind;
        } catch (\Doctrine\DBAL\Exception $th) {
            throw new Exception($th->getMessage());
        }
        
    }

    public function findByEmail(string $email): ?User
    {
        try {

            return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $email)
            ->getQuery()
            ->getOneOrNullResult();

        } catch (\Doctrine\DBAL\Exception $th) {
            throw new Error($th->getMessage());
        }
   
    }

    public function index(): array
    {
        try {
            return $this->createQueryBuilder('u')
            ->getQuery()
            ->getResult();
        } catch (\Doctrine\DBAL\Exception $th) {
            throw new Error($th->getMessage());
        }
    }

    public function findOneBySomeField(string $id): ?User
    {
       return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}

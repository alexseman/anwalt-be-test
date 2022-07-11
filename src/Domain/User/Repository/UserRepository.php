<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $userId
     *
     * @return User
     */
    public function findOrCreateUser(int $userId): User
    {
        $user = $this->findOneBy(['id' => $userId]);

        if (empty($user)) {
            $user = new User($userId);
        }

        $this->getEntityManager()->persist($user);
        return $user;
    }
}

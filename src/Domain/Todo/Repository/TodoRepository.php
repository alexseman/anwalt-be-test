<?php

declare(strict_types=1);

namespace App\Domain\Todo\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TodoRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    /**
     * @param string $title
     * @param int    $userId
     *
     * @return Todo|null
     */
    public function findOneByUserAndTitle(string $title, int $userId): ?Todo
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.title = :title')
            ->andWhere('t.user = :userId')
            ->setParameters([
                'title' => $title,
                'userId' => $userId
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $todoId
     *
     * @return int
     */
    public function deleteById(int $todoId): int
    {
        return $this->getEntityManager()->createQuery(<<<DQL
        DELETE FROM \App\Entity\Todo t WHERE t.id = :todoId
        DQL)
        ->execute(['todoId' => $todoId]);
    }
}

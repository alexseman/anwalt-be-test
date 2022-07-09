<?php

namespace App\Domain\Post\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findOneByUserAndTitle(string $title, int $userId): ?Post
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.title = :title')
            ->andWhere('p.user = :userId')
            ->setParameters([
                'title' => $title,
                'userId' => $userId
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $postId
     *
     * @return int
     */
    public function deleteById(int $postId): int
    {
        return $this->getEntityManager()->createQuery(<<<DQL
        DELETE FROM \App\Entity\Post p WHERE p.id = :postId
        DQL)
        ->execute(['postId' => $postId]);
    }
}

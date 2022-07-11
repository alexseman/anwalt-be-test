<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Service\Dto\ByUserTodo;
use App\Domain\Post\Query\UserPostsQueryBuilder;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param ByUserTodo $byUserPost
     *
     * @return Paginator
     */
    public function fetchPostList(ByUserTodo $byUserPost): Paginator
    {
        $offset = (($byUserPost->getCurrentPage() - 1) * $byUserPost->getPerPage());
        $query  = UserPostsQueryBuilder::getInstance($this->getEntityManager())
            ->build()
            ->applySpecification($byUserPost)
            ->setFirstResult($offset)
            ->setMaxResults($byUserPost->getPerPage());

        return new Paginator($query);
    }

    /**
     * @param string $title
     * @param int    $userId
     *
     * @return Post|null
     */
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

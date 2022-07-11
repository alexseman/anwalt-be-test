<?php

declare(strict_types=1);

namespace App\Domain\Post\Query;

use App\Domain\Post\Service\Dto\ByUserTodo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class UserPostsQueryBuilder extends QueryBuilder
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public static function getInstance(EntityManagerInterface $entityManager): self
    {
        return new self($entityManager);
    }

    public function build(): self
    {
        $this
            ->select('p')
            ->where('1')
            ->addOrderBy('p.id', 'DESC');

        return $this;
    }

    public function applySpecification(ByUserTodo $byUserPost): self
    {
        return $this
            ->applyUserId($byUserPost)
            ->applyTitle($byUserPost)
            ->applyBody($byUserPost);
    }

    public function applyUserId(ByUserTodo $byUserPost): self
    {
        if (null === $byUserPost->getUserId()) {
            return $this;
        }

        return $this
            ->andWhere('p.userId = :userId')
            ->setParameter('userId', $byUserPost->getUserId());
    }

    public function applyTitle(ByUserTodo $byUserPost): self
    {
        if (null === $byUserPost->getTitle()) {
            return $this;
        }

        return $this
            ->andWhere('p.title LIKE %:title%')
            ->setParameter('title', $byUserPost->getTitle());
    }

    public function applyBody(ByUserTodo $byUserPost): self
    {
        if (null === $byUserPost->getBody()) {
            return $this;
        }

        return $this
            ->andWhere('p.body LIKE %:body%')
            ->setParameter('body', $byUserPost->getBody());
    }
}

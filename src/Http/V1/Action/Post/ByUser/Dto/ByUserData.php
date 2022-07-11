<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Post\ByUser\Dto;

use App\Domain\Post\Service\Dto\ByUserResponse;
use App\Entity\Post;
use App\Http\V1\Response\Data\DataInterface;

class ByUserData implements DataInterface
{
    private ByUserResponse $byUserResponse;

    public function __construct(ByUserResponse $byUserResponse)
    {
        $this->byUserResponse = $byUserResponse;
    }

    /**
     * @param Post[] $posts
     *
     * @return array
     */
    public function transform(array $posts): array
    {
        $results = [];

        foreach ($posts as $post) {
            $results[] = [
                'id'        => $post->getId(),
                'title'     => $post->getTitle(),
                'body'      => $post->getBody(),
            ];
        }

        return $results;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->transform($this->byUserResponse->getPaginator()->getIterator()->getArrayCopy()),
            'pagination' => [
                'currentPage' => $this->byUserResponse->getPaginator()->getCurrentPage(),
                'totalItems' => $this->byUserResponse->getPaginator()->getNbResults(),
                'perPage' => $this->byUserResponse->getPaginator()->getMaxPerPage(),
                'totalPages' => $this->byUserResponse->getPaginator()->getNbPages(),
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\ByUser\Dto;

use App\Domain\Todo\Service\Dto\ByUserResponse;
use App\Entity\Todo;
use App\Http\V1\Response\Data\DataInterface;

class ByUserData implements DataInterface
{
    private ByUserResponse $byUserResponse;

    public function __construct(ByUserResponse $byUserResponse)
    {
        $this->byUserResponse = $byUserResponse;
    }

    /**
     * @param Todo[] $todos
     *
     * @return array
     */
    public function transform(array $todos): array
    {
        $results = [];

        foreach ($todos as $todo) {
            $results[] = [
                'id'        => $todo->getId(),
                'title'     => $todo->getTitle(),
                'dueOn'     => ($todo->getDueOn())->format('Y:m:d H:i:s'),
                'status'    => $todo->getStatus(),
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

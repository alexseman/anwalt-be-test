<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Read\Dto;

use App\Domain\Todo\Service\Dto\ReadResponse;
use App\Http\V1\Response\Data\DataInterface;

class ReadData implements DataInterface
{
    private ReadResponse $readResponse;

    public function __construct(ReadResponse $readResponse)
    {
        $this->readResponse = $readResponse;
    }

    public function jsonSerialize(): array
    {
        return [
            'todo' => [
                'id' => $this->readResponse->getTodo()->getId(),
                'userId' => $this->readResponse->getTodo()->getUser()->getId(),
                'title' => $this->readResponse->getTodo()->getTitle(),
                'dueOn' => ($this->readResponse->getTodo()->getDueOn())->format('Y:m:d H:i:s'),
                'status' => $this->readResponse->getTodo()->getStatus(),
            ]
        ];
    }
}

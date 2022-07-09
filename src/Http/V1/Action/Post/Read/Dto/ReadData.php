<?php

namespace App\Http\V1\Action\Post\Read\Dto;

use App\Domain\Post\Service\Dto\ReadResponse;
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
            'post' => [
                'id' => $this->readResponse->getPost()->getId(),
                'userId' => $this->readResponse->getPost()->getUser()->getId(),
                'title' => $this->readResponse->getPost()->getTitle(),
                'body' => $this->readResponse->getPost()->getBody(),
            ]
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Delete\Dto;

use App\Domain\Todo\Service\Dto\DeleteResponse;
use App\Http\V1\Response\Data\DataInterface;

class DeleteData implements DataInterface
{
    private DeleteResponse $deleteResponse;

    public function __construct(DeleteResponse $deleteResponse)
    {
        $this->deleteResponse = $deleteResponse;
    }

    public function jsonSerialize(): array
    {
        return [
            'count' => $this->deleteResponse->getCount(),
        ];
    }
}

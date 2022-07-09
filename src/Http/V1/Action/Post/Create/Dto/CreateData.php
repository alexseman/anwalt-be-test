<?php

namespace App\Http\V1\Action\Post\Create\Dto;

use App\Domain\Post\Service\Dto\CreateUpdateResponse;
use App\Http\V1\Response\Data\DataInterface;

class CreateData implements DataInterface
{

    private CreateUpdateResponse $createResponse;

    public function __construct(CreateUpdateResponse $createResponse)
    {
        $this->createResponse = $createResponse;
    }

	public function jsonSerialize(): array
	{
		return [
            'id' => $this->createResponse->getId()
        ];
	}
}

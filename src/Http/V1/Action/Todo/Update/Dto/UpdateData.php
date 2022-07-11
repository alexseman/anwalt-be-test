<?php

declare(strict_types=1);

namespace App\Http\V1\Action\Todo\Update\Dto;

use App\Domain\Todo\Service\Dto\CreateUpdateResponse;
use App\Http\V1\Response\Data\DataInterface;

class UpdateData implements DataInterface
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

<?php

declare(strict_types=1);

namespace App\Http\V1\Response\Data\Error;

use App\Http\V1\Response\Data\ErrorDataInterface;

class EmptyErrorData implements ErrorDataInterface
{

    public function getType(): string
    {
        return 'GENERAL';
    }

    public function jsonSerialize(): array
    {
        return [];
    }

}

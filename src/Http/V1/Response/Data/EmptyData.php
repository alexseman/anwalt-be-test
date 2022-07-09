<?php

declare(strict_types=1);

namespace App\Http\V1\Response\Data;

class EmptyData implements DataInterface
{

    public function jsonSerialize(): array
    {
        return [];
    }

}

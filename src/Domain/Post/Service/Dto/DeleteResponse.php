<?php

declare(strict_types=1);

namespace App\Domain\Post\Service\Dto;

class DeleteResponse
{
    private int $count;

    /**
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

}

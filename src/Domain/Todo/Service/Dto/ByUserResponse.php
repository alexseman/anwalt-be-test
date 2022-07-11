<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service\Dto;

use Pagerfanta\Pagerfanta;

class ByUserResponse
{
    private Pagerfanta $paginator;

    public function __construct(Pagerfanta $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @return Pagerfanta
     */
    public function getPaginator(): Pagerfanta
    {
        return $this->paginator;
    }
}

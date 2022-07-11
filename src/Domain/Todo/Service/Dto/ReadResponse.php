<?php

namespace App\Domain\Todo\Service\Dto;

use App\Entity\Todo;

class ReadResponse
{
    private Todo $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * @return Todo
     */
    public function getTodo(): Todo
    {
        return $this->todo;
    }
}
